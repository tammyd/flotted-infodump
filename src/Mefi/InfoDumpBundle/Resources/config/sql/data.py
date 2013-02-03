#!/usr/bin/python

# Quick script to load in the data files, as webfaction doesn't support mysql LOAD INFILE

import MySQLdb
import subprocess
import sys
import math
import time
import warnings
import os


class infodumpLoader:
    debug = False
    defaultOptions =  {'auto':False, 'max':400, 'skip':2, 'sanity':None, 'skip_check':False}

    def __del__(self):
        self.db.commit()
        self.cursor.close()
        self.db.close()

    def __init__(self, dbname, user, password, host, directory, dataOptions, debug=False, defaults={}):

        self.db = MySQLdb.connect(host,user,password,dbname)
        self.cursor = self.db.cursor()
        self.filedir = directory
        self.fileOptions = dataOptions
        self.debug = debug
        if defaults:
            self.defaultOptions = defaults

    def run(self):
        tables = []
        for table in self.fileOptions:
            tables.append(table)
        tables.sort()
        for table in tables:
            self.loadTable(table)

    def test(self, table, options):
        savedOptions = self.fileOptions[table]
        self.fileOptions[table] = options
        self.loadTable(table)
        self.fileOptions[table] = savedOptions

    def _execSQL(self, sql, values=[]):
        self.cursor.execute(sql, values)
        #print self.cursor._executed

#        if self.debug or True:
#            try:
#                with warnings.catch_warnings(record=True) as w:
#                    warnings.simplefilter("always")
#                    self.cursor.execute(sql, values)
#                    if len(w):
#                        print (w[0].message)
#                        raise Exception("SQL warning ")
#            except Exception:
#                print "Error with SQL stmt (%d values): %s:" % (len(values), sql)
#        else:
#            try:
#                self.cursor.execute(sql, values)
#            except Exception:
#                print "Error with SQL stmt (%d values): %s:" % (len(values), sql)
##        sys.stderr.write(sql + "\n")
##        sys.stderr.write(','.join(values))
##        sys.stderr.write("\n")


    def _runProcess(self, exe):
        p = subprocess.Popen(exe, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
        while(True):
            retcode = p.poll() #returns None while subprocess is running
            line = p.stdout.readline()
            yield line
            if(retcode is not None):
                break

    def _linecount(self, filename):
        result = self._runProcess(['wc', '-l', filename])
        line = result.next()
        result = line.strip().split(' ')[0]
        return int(result)

    def _tablecount(self, table):
        self._execSQL("SELECT count(*) from %s" % table)
        count = self.cursor.fetchone()[0]
        return count

    def getTableOption(self, table, key):
        retval = None
        if key in self.fileOptions[table]:
            retval = self.fileOptions[table][key]
        elif key in self.defaultOptions:
            retval = self.defaultOptions[key]
        else:
            retval = None

        return retval

    def checkTable(self, table):
        filename = self.getFilename(table)
        skipRows = self.getTableOption(table, 'skip')
        entries = self._linecount(filename) - skipRows
        count = self._tablecount(table)
        return entries==count

    def getFilename(self, table):
        return os.path.join(self.filedir, table + ".txt")

    def loadTable(self, table):
        filename = self.getFilename(table)
        skipRows = self.getTableOption(table, 'skip')
        sanityFtn = self.getTableOption(table, 'sanity')
        maxPerStmt = self.getTableOption(table, 'max')
        autoIncrement = self.getTableOption(table, 'auto')
        fileRecords = self._linecount(filename) - skipRows
        maxRows = self.getTableOption(table, 'max_rows')
        percentMarked = 0
        numberSkipped = 0
        startSQL = True
        endSQL = False
        skipCheck = self.getTableOption(table, 'skip_check')
        sqlStart = sqlPortion = ""

        sqlStmt = ""
        values = []

        if not skipCheck and self.checkTable(table):
            count = self._tablecount(table)
            print "%s already loaded with %d rows." % (table,count)
            return
        elif skipCheck:
            print "Skipping check of %s" % table


        startTime = time.time()
        self._execSQL("TRUNCATE table %s" % table)
        print "Truncated %s " % table
        print "Loading %s" % filename
        with open(filename) as infile:
            for i,line in enumerate(infile):
                if i < skipRows:
                    continue
                if maxRows and i >= (maxRows+skipRows+numberSkipped):
                    continue

                lineValues = line.strip().split('\t')
                if sanityFtn:
                    lineValues = sanityFtn(lineValues)
                    if lineValues is None:
                        numberSkipped+=1
                        sys.stderr.write('Sanity check failed for line %d of %s\n' % (i, filename))
                        continue

                if i % maxPerStmt == 0:
                    endSQL = True

                if startSQL:
                    sqlStmt = "INSERT into %s VALUES " % table
                    values = []
                    startSQL = False

                if autoIncrement:
                    sqlStart = "(null, %"
                else:
                    sqlStart = "(%"

                count = len(lineValues)-1
                sqlPortion = sqlStart + "s, %"*count + "s)"

                #ignore the unicode errors. Not sure what's going on w/ the db, but it's the best I can do.
                uni = [ unicode(x,errors='ignore') for x in lineValues ]
                values += uni

                sqlStmt += sqlPortion
                if endSQL:
                    endSQL = False
                    sqlStmt += ";"
                    self._execSQL(sqlStmt, values)
                    values = []
                    startSQL = True
                    percentMarked = self._markPercent(i,skipRows, fileRecords, percentMarked)
                else:
                    sqlStmt += ","

            #finish up
            sqlStmt = sqlStmt[0:-1] + ";"         #trim comma, add semi-colon
            self._execSQL(sqlStmt, values)        #add last rows
            percentMarked = self._markPercent(i+1,skipRows, fileRecords, percentMarked)

            count = self._tablecount(table)
            if self.checkTable(table):
                print "%s loaded successfully with %d rows." % (table,count)
            else:
                print "Inconsistant load of %s. Expected %d results, got %d. (Skipped %d)." % (table, fileRecords, count, numberSkipped)


    def _markPercent(self, i, skipRows, recordCount, percentMarked):
        percentDone = int(math.floor(100*(i-skipRows) / recordCount))
        if (percentDone > percentMarked):
            for i in range(percentMarked+1,percentDone+1):
                if i % 20 == 0:
                    print "%3d%%" % i
                elif i % 5 == 0:
                    print "%2d%%" % i,
                else:
                    print '.',

            sys.stdout.flush()
            percentMarked = percentDone
        return percentMarked


if __name__ == '__main__':

    try:
        host = sys.argv[1]
        user = sys.argv[2]
        password = sys.argv[3]
        dbname = sys.argv[4]
        dir = sys.argv[5]
    except Exception:
        print "Usage: %s <host> <user> <password> <dbname> <datadir>" % sys.argv[0]
        exit()

    def defaultSanity(lineValues, length):
    #If function returns False, then the line couldn't be saved.
    #Otherwise, return the "fixed" value
        if len(lineValues) != length:
            return None
        return lineValues

    def postDataSanity(lineValues):
        if defaultSanity(lineValues, 8) is None:
            return None
        for i in range(3,7):
            x = lineValues[i]
            if isinstance(x, basestring):
                if not x:
                    return None
        return lineValues

    def favoritesSanity(lineValues):
        if len(lineValues) != 7:
            return None

        return ['NULL'] + lineValues

    def appendLastSanity(lineValues, length, missing):
        if len(lineValues) == length:
            return lineValues
        if len(lineValues) == (length-1):
            return lineValues + [missing]
        else:
            return None

    def appendLastSanityWithIntTypeCheck(lineValues, length, missing):
        if len(lineValues) == length:
            return lineValues
        if len(lineValues) == (length-1):
            if isinstance(lineValues[length-2], (int, long) ):
                return lineValues + [missing]

        return None
    
    sites = {
        'postdata_music': {'sanity': lambda x:appendLastSanityWithIntTypeCheck(x, 8, '[NULL]')},
        'postdata_meta': {'sanity': lambda x:postDataSanity(x)},
        'postdata_askme': {'sanity': lambda x:appendLastSanityWithIntTypeCheck(x, 8, '[NULL]')},
        'postdata_mefi': {'sanity': lambda x:postDataSanity(x)},
        'postlength_music': {},
        'postlength_meta': {},
        'postlength_askme': {},
        'postlength_mefi': {},
        'tagdata_music': {},
        'tagdata_meta': {},
        'tagdata_askme': {},
        'tagdata_mefi': {},
        'commentdata_music': {},
        'commentdata_meta': {},
        'commentdata_askme': {},
        'commentdata_mefi': {},
        'commentlength_music': {},
        'commentlength_meta': {},
        'commentlength_askme': {},
        'commentlength_mefi': {},
        'contactdata': {'auto':True},
        'usernames': {},
        'favoritesdata': {'auto':True},
        'posttitles_music': {'sanity': lambda x:defaultSanity(x, 2)},
        'posttitles_meta': {'sanity': lambda x:defaultSanity(x, 2)},
        'posttitles_askme': {'sanity': lambda x:defaultSanity(x, 2)},
        'posttitles_mefi': {'sanity': lambda x:defaultSanity(x, 2)},
    }

    default = {'auto':False, 'max':400, 'skip':2, 'sanity':None, 'skip_check':False}
    loader = infodumpLoader(dbname,user, password,host,dir,sites, defaults=default)
    loader.run()








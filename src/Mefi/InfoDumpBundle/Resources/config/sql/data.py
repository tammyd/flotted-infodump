#!/usr/bin/python

# Quick script to load in the data files, as webfaction doesn't support mysql LOAD INFILE

import MySQLdb
import subprocess
import sys
import math
import time

def runProcess(exe):
    p = subprocess.Popen(exe, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
    while(True):
        retcode = p.poll() #returns None while subprocess is running
        line = p.stdout.readline()
        yield line
        if(retcode is not None):
            break


def execSQL(cursor, sql):
    try:
        cursor.execute(sql)
    except Exception:
        print "Error with SQL:"
        print sql
        print


def linecount(filename):
    result = runProcess(['wc', '-l', filename])
    line = result.next()
    result = line.strip().split(' ')[0]
    return int(result)

def tablecount(table, dbCursor):
    execSQL(dbCursor, "SELECT count(*) from %s" % table)
    count = dbCursor.fetchone()[0]
    return count

def checkLoad(filename, table, dbCursor, skipRows=2):
    entries = linecount(filename) - skipRows
    count = tablecount(table, dbCursor)
    return entries==count


def loadFile(filename, table, dbCursor, autoIncrement=False, skipRows=2, maxPerStmt=100):
    startSQL = True
    endSQL = False
    sqlStmt = ""
    recordCount = linecount(filename) - skipRows
    percentMarked = 0

    #check if we're already done...
    ok = checkLoad(filename, table, cursor, skipRows)
    if ok:
        count = tablecount(table, cursor)
        print "%s already loaded  with %d rows." % (table,count)
        return

    startTime = time.time()

    dbCursor.execute("TRUNCATE table %s" % table)

    print "Loading %s" % filename
    with open(filename) as infile:
        for i,line in enumerate(infile):
            if i < skipRows:
                continue

            if i % maxPerStmt == 0:
                endSQL = True

            if (autoIncrement):
                vals = 'null,"'+'","'.join(line.strip().split('\t'))+'"'
            else:
                vals = '"'+'","'.join(line.strip().split('\t'))+'"'

            if startSQL:
                sqlStmt = "INSERT into %s VALUES" % table
                startSQL = False

            sqlStmt = "%s (%s)" % (sqlStmt, vals)

            if endSQL:
                endSQL = False
                sqlStmt += ";"
                execSQL(cursor, sqlStmt)
                startSQL = True
                percentMarked = markPercent(i,skipRows, recordCount, percentMarked)
            else:
                sqlStmt += ","

        sqlStmt = sqlStmt[0:-1] + ";"   #trim comma, add semi-colon
        execSQL(cursor, sqlStmt)        #add last rows
        percentMarked = markPercent(i+1,skipRows, recordCount, percentMarked)

        ok = checkLoad(filename, table, cursor, skipRows)
        count = tablecount(table, cursor)
        if (ok):
            print "%s loaded successfully with %d rows." % (table,count)
        else:
            print "Inconsistant load of %s. Expected %d results, got %d." % (table, recordCount, count)
        print "Execution time: %0.02f sec" % (time.time()-startTime)

def markPercent(i, skipRows, recordCount, percentMarked):
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

    subsites = ['music','meta','askme','meta']
    common = ['postdata', 'postlength','posttitles','tagdata',  'commentdata', 'commentlength']
    others = ['favoritesdata', 'contactdata', 'usernames']

    extras = {
        'favoritesdata':{'auto':True},
        'postdata_music':{'max':1}
    }

    def getExtraTableVal(table, key):
        retval = None
        if table in extras:
            if key in extras[table]:
                retval = extras[table][key]
        return retval

    def loadFileWithOptions(filename, table, cursor):
        auto = True if getExtraTableVal(table, 'auto') else False
        if getExtraTableVal(table, 'max'):
            loadFile(filename, table, cursor, auto, maxPerStmt=getExtraTableVal(table, 'max'))
        else:
            loadFile(filename, table, cursor, auto)


    autoincrement = {'favoritesdata'}
    maxPerStmt = {'postdata_music':1}

    db = MySQLdb.connect(host,user,password,dbname)
    cursor=db.cursor()

    testTables = ['posttitles_music','posttitles_meta','posttitles_askme','posttitles_mefi']

    if len(testTables) > 0:
        for table in testTables:
            filename = "%s/%s.txt" % (dir, table)
            auto = True if getExtraTableVal(table, 'auto') else False
            loadFile(filename, table, cursor, auto, maxPerStmt=1)
        exit()

    for site in subsites:
        for section in common:
            table = '%s_%s' % (section, site)
            filename = "%s/%s.txt" % (dir, table)
            loadFileWithOptions(filename, table, cursor)

    for table in others:
        filename = "%s/%s.txt" % (dir, table)
        loadFileWithOptions(filename, table, cursor)





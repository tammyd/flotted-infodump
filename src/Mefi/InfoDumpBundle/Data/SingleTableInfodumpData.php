<?php

namespace Mefi\InfoDumpBundle\Data;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;

class SingleTableInfodumpData extends InfodumpData
{
    protected $className;

    public function __construct(EntityManager $em, $useCache=true, $cacheTime=3600)
    {
        parent::__construct($em, $useCache, $cacheTime);
    }

    public function getClassMetadata() {
        return $this->getEntityManager()->getClassMetadata($this->getClassName());

    }

    public function getTableName() {
        return $this->getClassMetadata()->getTableName();
    }

    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function getCountByDate($dateField)
    {
        $table = $this->getTableName();
        $sql = "select count(*) as count, date($dateField) as date from $table group by date order by date asc";

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('date', 'date', 'string');
        $rsm->addScalarResult('count', 'count', 'integer');

        $cacheKey = $this->buildCacheKey(__FUNCTION__, $dateField);
        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($this->getUseCache(), $this->getCacheTime(), $cacheKey)
            ->getResult();

    }

    public function getCountByYear($dateField)
    {
        $table = $this->getTableName();
        $sql = "select count(*) as count, year($dateField) as date from $table group by date order by date asc";

        $rsm = $this->buildSingleTypeRSM(array('date', 'count'), 'integer');
        $cacheKey = $this->buildCacheKey(__FUNCTION__, $dateField);
        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($this->getUseCache(), $this->getCacheTime(), $cacheKey)
            ->getResult();
    }

    public function getCountByMonth($dateField)
    {
        $table = $this->getTableName();
        $sql = "select count(*) as count, CONCAT_WS('-',year($dateField), LPAD(month($dateField), 2, '0')) as date from $table group by date order by date asc";

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('date', 'date', 'string');
        $rsm->addScalarResult('count', 'count', 'integer');

        $cacheKey = $this->buildCacheKey(__FUNCTION__, $dateField);
        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($this->getUseCache(), $this->getCacheTime(), $cacheKey)
            ->getResult();
    }

    public function getCountByMonthYear($dateField) {
        $table = $this->getTableName();
        $sql = <<<SQL
SELECT COUNT( * ) AS count, month($dateField) as month, year($dateField) as year
FROM $table
GROUP BY month,year
ORDER BY year asc, month asc
SQL;

        $rsm = $this->buildSingleTypeRSM(array('count', 'month', 'year'), 'integer');
        $cacheKey = $this->buildCacheKey(__FUNCTION__, $dateField);
        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($this->getUseCache(), $this->getCacheTime(), $cacheKey)
            ->getResult();
    }

    public function getCountByYearDayOfWeek($dateField)
    {
        $table = $this->getTableName();
        $sql = "SELECT COUNT( * ) AS count, year($dateField) as year, DAYOFWEEK( $dateField ) AS dow FROM $table GROUP BY year,dow ORDER BY year asc, dow ASC ";
        $rsm = $this->buildSingleTypeRSM(array('dow', 'count', 'year'), 'integer');
        $cacheKey = $this->buildCacheKey(__FUNCTION__, $dateField);
        $result = $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($this->getUseCache(), $this->getCacheTime(), $cacheKey)
            ->getResult();
        return $result;
    }

    public function getCountByHour($dateField) {
        $table = $this->getTableName();
        $sql = "select count(*) as count, hour($dateField) as hour from $table group by hour order by hour asc;";

        $cacheKey = $this->buildCacheKey(__FUNCTION__, $dateField);
        $rsm = $this->buildSingleTypeRSM(array('hour', 'count'), 'integer');
        $result = $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($this->getUseCache(), $this->getCacheTime(), $cacheKey)
            ->getResult();
        return $result;
    }

    protected function getSQLQueryArrayResult($sql, $where=null, $params=null) {
        
    }

    protected function getCachePrefix() {
        return $this->getTableName();
    }





}
<?php

namespace Mefi\InfoDumpBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use  Doctrine\ORM\Query\ResultSetMapping;

abstract class InfodumpRepository extends EntityRepository
{
    protected function getCachePrefix() {
        return $this->getClassMetadata()->getTableName();
    }

    public function getCountByDate($dateField, $cache=true, $cacheTime=3600)
    {
        $table = $this->getClassMetadata()->getTableName();
        $sql = "select count(*) as count, date($dateField) as date from $table group by date order by date asc";

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('date', 'date', 'string');
        $rsm->addScalarResult('count', 'count', 'integer');

        $cacheKey = $this->buildCacheKey(__FUNCTION__, $dateField);
        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($cache, $cacheTime, $cacheKey)
            ->getResult();

    }


    public function getCountByMonth($dateField, $cache=true, $cacheTime=3600)
    {
        $table = $this->getClassMetadata()->getTableName();
        $sql = "select count(*) as count, CONCAT_WS('-',year($dateField), LPAD(month($dateField), 2, '0')) as date from $table group by date order by date asc";

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('date', 'date', 'string');
        $rsm->addScalarResult('count', 'count', 'integer');

        $cacheKey = $this->buildCacheKey(__FUNCTION__, $dateField);
        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($cache, $cacheTime, $cacheKey)
            ->getResult();
    }

    public function getCountByMonthYear($dateField, $cache=true, $cacheTime=3600)
    {
        $table = $this->getClassMetadata()->getTableName();
        $sql = <<<SQL
SELECT COUNT( * ) AS count, month($dateField) as month, year($dateField) as year
FROM $table
GROUP BY month,year
ORDER BY year asc, month asc
SQL;

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('count', 'count', 'integer');
        $rsm->addScalarResult('month', 'month', 'integer');
        $rsm->addScalarResult('year', 'year', 'integer');

        $cacheKey = $this->buildCacheKey(__FUNCTION__, $dateField);
        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($cache, $cacheTime, $cacheKey)
            ->getResult();
    }

    public function getCountByYear($dateField, $cache=true, $cacheTime=3600)
    {
        $table = $this->getClassMetadata()->getTableName();
        $sql = "select count(*) as count, year($dateField) as date from $table group by date order by date asc";

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('date', 'date', 'integer');
        $rsm->addScalarResult('count', 'count', 'integer');

        $cacheKey = $this->buildCacheKey(__FUNCTION__, $dateField);
        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($cache, $cacheTime, $cacheKey)
            ->getResult();
    }

    public function getCountByYearDayOfWeek($dateField, $cache=true, $cacheTime=3600)
    {
        $table = $this->getClassMetadata()->getTableName();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('dow', 'dow', 'integer');
        $rsm->addScalarResult('count', 'count', 'integer');
        $rsm->addScalarResult('year', 'year', 'integer');
        $sql = "SELECT COUNT( * ) AS count, year($dateField) as year, DAYOFWEEK( $dateField ) AS dow FROM $table GROUP BY year,dow ORDER BY year asc, dow ASC ";

        $cacheKey = $this->buildCacheKey(__FUNCTION__, $dateField);
        $result = $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($cache, $cacheTime, $cacheKey)
            ->getResult();
        return $result;
    }

    public function getCountByHour($datefield, $cache=true, $cacheTime=3600)
    {
        $table = $this->getClassMetadata()->getTableName();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('hour', 'hour', 'integer');
        $rsm->addScalarResult('count', 'count', 'integer');
        $sql = "select count(*) as count, hour($datefield) as hour from $table group by hour order by hour asc;";

        $cacheKey = $this->buildCacheKey(__FUNCTION__, $datefield);

        $result = $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->useResultCache($cache, $cacheTime, $cacheKey)
            ->getResult();
        return $result;
    }

    protected function buildCacheKey($function, $args) {
        return $this->getCachePrefix().":".$function.":".md5(json_encode($args));
    }

}
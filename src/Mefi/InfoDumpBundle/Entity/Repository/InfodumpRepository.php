<?php

namespace Mefi\InfoDumpBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use  Doctrine\ORM\Query\ResultSetMapping;

abstract class InfodumpRepository extends EntityRepository
{

    public function getCountByDate($dateField)
    {
        $table = $this->getClassMetadata()->getTableName();
        $sql = "select count(*) as count, date($dateField) as date from $table group by date order by date asc";

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('date', 'date', 'string');
        $rsm->addScalarResult('count', 'count', 'integer');
        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->getResult();

    }

    public function getCountByMonthYear($dateField)
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

        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->getResult();
    }

    public function getCountByYear($dateField)
    {
        $table = $this->getClassMetadata()->getTableName();
        $sql = "select count(*) as count, year($dateField) as date from $table group by date order by date asc";

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('date', 'date', 'integer');
        $rsm->addScalarResult('count', 'count', 'integer');

        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->getResult();
    }

    public function getCountByYearDayOfWeek($dateField)
    {
        $table = $this->getClassMetadata()->getTableName();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('dow', 'dow', 'integer');
        $rsm->addScalarResult('count', 'count', 'integer');
        $rsm->addScalarResult('year', 'year', 'integer');
        $sql = "SELECT COUNT( * ) AS count, year($dateField) as year, DAYOFWEEK( $dateField ) AS dow FROM $table GROUP BY year,dow ORDER BY year asc, dow ASC ";

        $result = $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->getResult();
        return $result;
    }

    public function getCountByHour($datefield)
    {
        $table = $this->getClassMetadata()->getTableName();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('hour', 'hour', 'integer');
        $rsm->addScalarResult('count', 'count', 'integer');
        $sql = "select count(*) as count, hour($datefield) as hour from $table group by hour order by hour asc;";
        $result = $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->getResult();
        return $result;
    }

}
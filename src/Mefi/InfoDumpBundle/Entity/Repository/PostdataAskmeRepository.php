<?php

namespace Mefi\InfoDumpBundle\Entity\Repository;

use Mefi\InfoDumpBundle\Entity\Repository\InfodumpRepository;
use  Doctrine\ORM\Query\ResultSetMapping;

class PostdataAskmeRepository extends InfodumpRepository
{
    const DATE_FIELD = 'datestamp';

    public function getCountPostsByDate()
    {
        return $this->getCountByDate(self::DATE_FIELD);
    }

    public function getCountPostsByMonth()
    {
        return $this->getCountByMonthYear(self::DATE_FIELD);
    }

    public function getCountPostsByYear()
    {
        return $this->getCountByYear(self::DATE_FIELD);
    }

    public function getCountPostsByDayOfWeek()
    {
        return $this->getCountByYearDayOfWeek(self::DATE_FIELD);
    }

    public function getCountPostsByHour()
    {
        return $this->getCountByHour(self::DATE_FIELD);
    }

    public function getDeletedPostsByMonth()
    {

        $table = $this->getClassMetadata()->getTableName();
        $field = self::DATE_FIELD;
        $sql = <<<SQL
SELECT COUNT( * ) AS count, month($field) as month, year($field) as year
FROM $table
WHERE deleted = ?
GROUP BY month,year
ORDER BY year asc, month asc
SQL;

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('count', 'count', 'integer');
        $rsm->addScalarResult('month', 'month', 'integer');
        $rsm->addScalarResult('year', 'year', 'integer');

        $cacheKey = $this->buildCacheKey(__FUNCTION__, self::DATE_FIELD);
        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->setParameter(1, 1)
            ->useResultCache(true, 3600, $cacheKey)
            ->getResult();
    }


}
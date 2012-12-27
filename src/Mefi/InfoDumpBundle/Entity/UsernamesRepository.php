<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\EntityRepository;
use  Doctrine\ORM\Query\ResultSetMapping;

class UsernamesRepository extends EntityRepository
{

    private function dowToString($i) {
        return date('D', strtotime("Saturday +{$i} days"));
    }

    public function getCountSignupsByDate()
    {
        $sql = "select count(*) as count, date(joindate) as date from usernames group by date order by date asc";

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('date', 'date', 'string');
        $rsm->addScalarResult('count', 'count', 'integer');
        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->getResult();

    }

    public function getCountSignupsByMonth()
    {

        $sql = <<<SQL
SELECT COUNT( * ) AS count, month(joindate) as month, year(joindate) as year
FROM usernames
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

    public function getCountSignupsByYear()
    {
        $sql = "select count(*) as count, year(joindate) as date from usernames group by date order by date asc";

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('date', 'date', 'integer');
        $rsm->addScalarResult('count', 'count', 'integer');

        return $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->getResult();
    }

    public function getCountSignupsByDayOfWeek() {

        $rsm = new ResultSetMapping(); //Apparently using raw sql with the connection object isn't very doctrinific, this is the 'right' way.
        $rsm->addScalarResult('dow', 'dow', 'integer');
        $rsm->addScalarResult('count', 'count', 'integer');
        $rsm->addScalarResult('year', 'year', 'integer');
        $sql = "SELECT COUNT( * ) AS count, year(joindate) as year, DAYOFWEEK( joindate ) AS dow FROM usernames GROUP BY year,dow ORDER BY year asc, dow ASC ";

        $result = $this->getEntityManager()
            ->createNativeQuery($sql, $rsm)
            ->getResult();

        $result = array_map(function ($r)  { $r['dayOfWeek']=$this->dowToString($r['dow']); return $r; }, $result);
        return $result;

    }

}
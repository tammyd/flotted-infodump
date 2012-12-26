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
        $conn = $this->getEntityManager()->getConnection();
        $sql = "select count(*) as count, date(joindate) as date from usernames group by date order by date asc";
        return $conn->fetchAll($sql);
    }

    public function getCountSignupsByMonth()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = <<<SQL

SELECT COUNT( * ) AS count, month(joindate) as month, year(joindate) as year
FROM usernames
GROUP BY month,year
ORDER BY year asc, month asc

SQL;

        return $conn->fetchAll($sql);
    }

    public function getCountSignupsByYear()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "select count(*) as count, year(joindate) as date from usernames group by date order by date asc";
        return $conn->fetchAll($sql);
    }

    public function getCountSignupsByDayOfWeek() {

        $rsm = new ResultSetMapping(); //Apparently using raw sql with the connection object isn't very doctrinific, this is the 'right' way.
        $rsm->addScalarResult('dow', 'dow', 'integer');
        $rsm->addScalarResult('count', 'count', 'integer');
        $rsm->addScalarResult('year', 'year', 'integer');
        $sql = "SELECT COUNT( * ) AS count, year(joindate) as year, DAYOFWEEK( joindate ) AS dow FROM usernames GROUP BY year,dow ORDER BY year asc, dow ASC ";

        $em = $this->getEntityManager();
        $query = $em->createNativeQuery($sql, $rsm);
        $result = $query->getResult();

        $result = array_map(function ($r)  { $r['dayOfWeek']=$this->dowToString($r['dow']); return $r; }, $result);
        return $result;

    }

}
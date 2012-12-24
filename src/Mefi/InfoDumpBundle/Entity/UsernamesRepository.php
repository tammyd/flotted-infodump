<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UsernamesRepository extends EntityRepository
{
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

}
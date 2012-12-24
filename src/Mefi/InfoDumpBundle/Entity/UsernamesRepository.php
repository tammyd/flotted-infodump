<?php

namespace Mefi\InfoDumpBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UsernamesRepository extends EntityRepository
{
    public function getCountSignupsByDate()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "select count(*) as count, date(joindate) as date from usernames group by date order by date asc limit 7";
        return $conn->fetchAll($sql);
    }

    public function getCountSignupsByMonth()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = <<<SQL

SELECT COUNT( * ) AS count, DATE_FORMAT( joindate,  '%b %Y' ) AS DATE
FROM usernames
GROUP BY DATE_FORMAT( joindate,  '%Y %m' )
ORDER BY DATE_FORMAT( joindate,  '%Y %m' ) ASC

SQL;

        return $conn->fetchAll($sql);
    }
}
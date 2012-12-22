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
}
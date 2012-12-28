<?php

namespace Mefi\InfoDumpBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Mefi\InfoDumpBundle\Entity\Repository\InfodumpRepository;

class UsernamesRepository extends InfodumpRepository
{

    public function getCountSignupsByDate()
    {

        return $this->getCountByDate('joindate');

    }

    public function getCountSignupsByMonth()
    {

        return $this->getCountByMonthYear('joindate');
    }

    public function getCountSignupsByYear()
    {
        return $this->getCountByYear('joindate');
    }

    public function getCountSignupsByDayOfWeek() {


        return $this->getCountByYearDayOfWeek('joindate');

    }

}
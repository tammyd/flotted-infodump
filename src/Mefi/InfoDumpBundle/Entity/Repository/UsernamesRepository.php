<?php

namespace Mefi\InfoDumpBundle\Entity\Repository;

use Mefi\InfoDumpBundle\Entity\Repository\InfodumpRepository;

class UsernamesRepository extends InfodumpRepository
{
    const DATE_FIELD = 'joindate';

    public function getCountSignupsByDate()
    {
        return $this->getCountByDate(self::DATE_FIELD);
    }

    public function getCountSignupsByMonth()
    {

        return $this->getCountByMonthYear(self::DATE_FIELD);
    }

    public function getCountSignupsByYear()
    {
        return $this->getCountByYear(self::DATE_FIELD);
    }

    public function getCountSignupsByDayOfWeek()
    {
        return $this->getCountByYearDayOfWeek(self::DATE_FIELD);
    }

    public function getCountSignupsByHour()
    {
        return $this->getCountByHour(self::DATE_FIELD);
    }

}
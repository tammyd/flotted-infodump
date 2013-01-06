<?php

namespace Mefi\InfoDumpBundle\Entity\Repository;

use Mefi\InfoDumpBundle\Entity\Repository\InfodumpRepository;

class UsernamesRepository extends InfodumpRepository
{
    const DATE_FIELD = 'joindate';

    public function findCountSignupsByDate()
    {
        return $this->getCountByDate(self::DATE_FIELD);
    }

    public function findCountSignupsByMonthYear()
    {

        return $this->getCountByMonthYear(self::DATE_FIELD);
    }

    public function findCountSignupsByYear()
    {
        return $this->getCountByYear(self::DATE_FIELD);
    }

    public function findCountSignupsByDayOfWeek()
    {
        return $this->getCountByYearDayOfWeek(self::DATE_FIELD);
    }

    public function findCountSignupsByHour()
    {
        return $this->getCountByHour(self::DATE_FIELD);
    }

    public function findCountByMonth() {
        return $this->getCountByMonth(self::DATE_FIELD);
    }

}
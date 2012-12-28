<?php

namespace Mefi\InfoDumpBundle\Entity\Repository;

use Mefi\InfoDumpBundle\Entity\Repository\InfodumpRepository;

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

}
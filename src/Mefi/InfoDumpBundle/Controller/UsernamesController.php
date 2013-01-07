<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Mefi\InfoDumpBundle\Data\UsernamesData;

class UsernamesController extends JsonDataController
{


    public function signupsByDateDataAction() {

        $data = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:Usernames')
            ->getCountByDate('joindate');
        return $this->jsonResponse($data);
    }

    public function signupsByYearDataAction() {

        $data = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:Usernames')
            ->getCountByYear(UsernamesData::DATE_FIELD);
        return $this->jsonResponse($data);

    }

    public function signupsByMonthDataAction() {

        $data = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:Usernames')
            ->getCountByMonth(UsernamesData::DATE_FIELD);
        return $this->jsonResponse($data);
    }


    public function signupsByMonthYearDataAction() {
        $rawData = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:Usernames')
            ->getCountByMonthYear(UsernamesData::DATE_FIELD);

        $data = array();
        foreach ($rawData as $record) {

            if (!isset($data[$record['year']])) {
                $data[$record['year']] = array();
            }
            $data[$record['year']][$record['month']] = intval($record['count']);
        }

        $data = $this->normalize2DData($data);
        return $this->jsonResponse($data);
    }

    public function signupsByDOWDataAction() {
        $rawData = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:Usernames')
            ->getCountByYearDayOfWeek(UsernamesData::DATE_FIELD);

        $data = array();
        foreach ($rawData as $record) {
            if (!isset($data[$record['year']])) {
                $data[$record['year']] = array();
            }
            $data[$record['year']][$record['dow']] = $record['count'];
        }

        $data = $this->normalize2DData($data);
        return $this->jsonResponse($data);
    }

    public function signupsByHourDataAction() {
        $data = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:Usernames')
            ->getCountByHour(UsernamesData::DATE_FIELD);
        return $this->jsonResponse($data);
    }

    public function signupsByDateContentAction() {
        return new Response("<p class='lead'>Signups By Date</p>");
    }

    public function signupsByMonthYearContentAction() {
        return new Response("<p class='lead'>Signups By Month & Year</p>");
    }

    public function signupsByYearContentAction() {
        return new Response("<p class='lead'>Signups By Year</p>");
    }

    public function signupsByDOWContentAction() {
        return new Response("<p class='lead'>Signups By Day Of Week</p>");
    }

    public function signupsByHourContentAction() {
        return new Response("<p class='lead'>Signups By Hour (PST?)</p>");
    }

    public function signupsByMonthContentAction() {
        return new Response("<p class='lead'>Signups By Month</p>");
    }
}

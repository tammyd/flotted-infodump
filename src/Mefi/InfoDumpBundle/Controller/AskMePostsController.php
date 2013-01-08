<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class AskMePostsController extends JsonDataController
{


    public function postsByDateDataAction() {

        $data = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByDate('datestamp');
        return $this->jsonResponse($data);
    }

    public function postsByYearDataAction() {

        $data = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByYear('datestamp');
        return $this->jsonResponse($data);

    }

    public function postsByMonthYearDataAction() {
        $rawData = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByMonthYear('datestamp');

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

    public function postsByDOWDataAction() {
        $rawData = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByYearDayOfWeek('datestamp');

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


    public function postsByHourDataAction() {
        $data = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByHour('datestamp');
        return $this->jsonResponse($data);
    }


    public function postsByMonthDataAction() {

        $data = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByMonth('datestamp');
        return $this->jsonResponse($data);
    }

    public function deletedPostsByMonthDataAction() {

        $data = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByMonth('datestamp', 'deleted = 1');
        return $this->jsonResponse($data);
    }


    public function deletedPostsByMonthYearDataAction()
    {
        $rawData = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByMonthYear('datestamp', 'deleted = 1');

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

    public function deletedPostsByHourDataAction() {
        $data = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByHour('datestamp', 'deleted = 1');
        return $this->jsonResponse($data);
    }

    public function deletedPostsByDOWDataAction() {
        $rawData = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByYearDayOfWeek('datestamp', 'deleted = 1');

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

    static function cmpDates($a, $b) {
        $adt = new \DateTime($a['date']);
        $bdt = new \DateTime($b['date']);
        return ($adt < $bdt) ? -1 : 1;
    }

    public function deletedPostsByDateDataAction() {

        $rawData = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByDate('datestamp', 'deleted = 1');

        $dates = array_map(function($x) { return new \DateTime($x['date']); }, $rawData);
        $interval = new \DateInterval('P1D');
        $prev = null;
        foreach ($dates as $date) {
            $curr = $date;
            if ($prev) {
                $daterange = new \DatePeriod($prev, $interval ,$curr);
                foreach ($daterange as $date) {
                    $rawData[] = array('count'=>0, 'date'=>$date->format('Y-m-d'));
                }
            }
            $prev = $curr->modify('+1 day');
        }
        usort($rawData, array("self", "cmpDates"));
        return $this->jsonResponse($rawData);
    }

    public function deletedPostsByYearDataAction() {

        $data = $this->get('infodump.singletable.data')
            ->setClassName('MefiInfoDumpBundle:PostdataAskme')
            ->getCountByYear('datestamp', 'deleted = 1');
        return $this->jsonResponse($data);

    }


    public function postsByMonthContentAction() {
        return new Response("<p class='lead'>Number of AskMe Posts By Month</p>");
    }

    public function postsByDateContentAction() {
        return new Response("<p class='lead'>Number of AskMe Posts By Date</p>");
    }

    public function postsByHourContentAction() {
        return new Response("<p class='lead'>Number of AskMe Posts By Hour (PST?)</p>");
    }

    public function postsByYearContentAction() {
        return new Response("<p class='lead'>Number of AskMe Posts By Year</p>");
    }

    public function postsByDOWContentAction() {
        return new Response("<p class='lead'>Number of AskMe Posts By Month</p>");
    }

    public function postsByMonthYearContentAction() {
        return new Response("<p class='lead'>Number of AskMe Posts By Month & Year</p>");
    }

    public function deletedPostsByMonthContentAction() {
        return new Response("<p class='lead'>Number of Deleted Askme Posts By Month</p>");
    }

    public function deletedPostsByDateContentAction() {
        return new Response("<p class='lead'>Number of Deleted Askme Posts By Date</p>");
    }

    public function deletedPostsByHourContentAction() {
        return new Response("<p class='lead'>Number of Deleted Askme Posts By Hour (PST?)</p>");
    }

    public function deletedPostsByYearContentAction() {
        return new Response("<p class='lead'>Number of Deleted Askme Posts By Year</p>");
    }

    public function deletedPostsByDOWContentAction() {
        return new Response("<p class='lead'>Number of Deleted Askme Posts By Month</p>");
    }

    public function deletedPostsByMonthYearContentAction() {
        return new Response("<p class='lead'>Number of Deleted Askme Posts By Month & Year</p>");
    }


}
<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class AskMePostsController extends JsonDataController
{
    public function postsByDateContentAction() {
        return new Response("<p class='lead'>Number of AskMe Posts By Date</p>");
    }

    public function postsByDateDataAction() {

        $all = $this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:PostdataAskme')
            ->getCountPostsByDate();

        return $this->jsonResponse($all);
    }



    public function postsByYearContentAction() {
        return new Response("<p class='lead'>Number of AskMe Posts By Year</p>");
    }

    public function postsByYearDataAction() {

        $all = $this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:PostdataAskme')
            ->getCountPostsByYear();

        return $this->jsonResponse($all);
    }


    public function postsByMonthContentAction() {
        return new Response("<p class='lead'>Number of AskMe Posts By Month</p>");
    }

    public function postsByMonthDataAction() {

        $all = $this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:PostdataAskme')
            ->getCountPostsByMonth();

        $data = array();
        foreach ($all as $record) {
            $year = intval($record['year']);
            $month = intval($record['month']);
            $count = intval($record['count']);

            if (!isset($data[$year])) {
                $data[$year] = array();
            }
            $data[$year][$month] = intval($count);
        }

        $data = $this->normalize2DData($data);
        return $this->jsonResponse($data);
    }

    public function postsByDOWContentAction() {
        return new Response("<p class='lead'>Number of AskMe Posts By Month</p>");
    }

    public function postsByDOWDataAction() {
        $arrData = $this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:PostdataAskme')
            ->getCountPostsByDayOfWeek();

        $data = array();
        foreach ($arrData as $record) {
            $year = intval($record['year']);
            $dow = intval($record['dow']);
            $count = intval($record['count']);

            if (!isset($data[$year])) {
                $data[$year] = array();
            }
            $data[$year][$dow] = $count;
        }

        $data = $this->normalize2DData($data);
        return $this->jsonResponse($data);
    }


    public function postsByHourDataAction() {
        $em = $this->getDoctrine()->getManager();
        $all = $em->getRepository('MefiInfoDumpBundle:PostdataAskme')->getCountPostsByHour();
        return $this->jsonResponse($all);
    }

    public function postsByHourContentAction() {
        return new Response("<p class='lead'>Number of AskMe Posts By Hour (PST?)</p>");
    }

    public function deletedPostsByMonthContentAction() {
        return new Response("<p class='lead'>Number of Deleted AskMe Posts By Month</p>");
    }

    public function deletedPostsByMonthDataAction() {

        $all = $this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:PostdataAskme')
            ->getDeletedPostsByMonth();

        $data = array();
        foreach ($all as $record) {
            $year = intval($record['year']);
            $month = intval($record['month']);
            $count = intval($record['count']);

            if (!isset($data[$year])) {
                $data[$year] = array();
            }
            $data[$year][$month] = intval($count);
        }

        $data = $this->normalize2DData($data);
        return $this->jsonResponse($data);
    }

}
<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class UsernamesController extends JsonDataController
{

    public function signupsByDateDataAction() {

        $all = $this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:Usernames')
            ->findCountSignupsByDate();

        return $this->jsonResponse($all);
    }

    public function signupsByYearDataAction() {

        $all = $this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:Usernames')
            ->findCountSignupsByYear();

        return $this->jsonResponse($all);

    }

    public function signupsByMonthDataAction() {
        $result = $this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:Usernames')
            ->findCountByMonth();

        return $this->jsonResponse($result);
    }


    public function signupsByMonthYearDataAction() {

        $all = $this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:Usernames')
            ->findCountSignupsByMonthYear();

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

    public function signupsByDOWDataAction() {
        $arrData = $this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:Usernames')
            ->findCountSignupsByDayOfWeek();

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

    public function signupsByHourDataAction() {
        $all = $this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:Usernames')
            ->findCountSignupsByHour();
        return $this->jsonResponse($all);
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

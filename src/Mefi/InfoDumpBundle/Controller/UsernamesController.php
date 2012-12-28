<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class UsernamesController extends JsonDataController
{

    public function signupsByDateDataAction() {

        $em = $this->getDoctrine()->getManager();
        $all = $em->getRepository('MefiInfoDumpBundle:Usernames')->getCountSignupsByDate();

        return $this->jsonResponse($all);
    }

    public function signupsByYearDataAction() {

        $em = $this->getDoctrine()->getManager();
        $all = $em->getRepository('MefiInfoDumpBundle:Usernames')->getCountSignupsByYear();

        return $this->jsonResponse($all);

    }


    public function signupsByMonthDataAction() {

        $em = $this->getDoctrine()->getManager();
        $all = $em->getRepository('MefiInfoDumpBundle:Usernames')->getCountSignupsByMonth();

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
            ->getCountSignupsByDayOfWeek();

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

    public function signupsByDateContentAction() {
        return new Response("<p class='lead'>Signups By Date</p>");
    }

    public function signupsByMonthContentAction() {
        return new Response("<p class='lead'>Signups By Month</p>");
    }

    public function signupsByYearContentAction() {
        return new Response("<p class='lead'>Signups By Year</p>");
    }

    public function signupsByDOWContentAction() {
        return new Response("<p class='lead'>Signups By Day Of Week</p>");
    }
}

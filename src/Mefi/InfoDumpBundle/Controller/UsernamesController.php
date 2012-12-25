<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;



class UsernamesController extends JsonDataController
{

    public function signupsByDateDataAction() {

        $em = $this->getDoctrine()->getManager();
        $all = $em->getRepository('MefiInfoDumpBundle:Usernames')->getCountSignupsByDate();


        $response = new Response(json_encode($all));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


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

        //TODO: empty data for Dec 04. Normalize this!

        return $this->jsonResponse($data);
    }

    public function signupsByDOWDataAction() {
        return $this->jsonResponse($this->getDoctrine()
            ->getManager()
            ->getRepository('MefiInfoDumpBundle:Usernames')
            ->getCountSignupsByDayOfWeek());
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

<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Response;



class UserInfoController extends Controller
{
    public function testDataAction()
    {

        //return $this->render('MefiInfoDumpBundle:UserInfo:test.html.twig', array('test'=>'This is a test'));
        $response = new Response(json_encode(array('d1' => array(1,2,3,4))));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function testContentAction()
    {
        return $this->render('MefiInfoDumpBundle:UserInfo:test.html.twig');
    }

    public function signupsByDateDataAction() {

        /** @var $conn Connection */
//        $conn = $this->getDoctrine()
//            ->getManager()
//            ->getConnection();
//        $sql = "select count(*) as count, date(joindate) as date from usernames group by date order by date asc";
//        $all = $conn->fetchAll($sql);

        $em = $this->getDoctrine()->getManager();
        $all = $em->getRepository('MefiInfoDumpBundle:Usernames')->getCountSignupsByDate();


        $response = new Response(json_encode($all));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }

    public function signupsByDateContentAction() {
        return new Response("<p class='lead'>Signups By Date</p>");
    }
}

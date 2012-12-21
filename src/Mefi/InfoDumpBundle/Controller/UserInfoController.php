<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Response;



class UserInfoController extends Controller
{
    public function testDataAction()
    {


        /** @var $conn Connection */
        $conn = $this->getDoctrine()
            ->getManager()
            ->getConnection();
        $sql = "SELECT COUNT( * ) AS signups, YEAR( joindate ) AS YEAR, MONTH( joindate ) AS MONTH FROM
                usernames  GROUP BY YEAR, MONTH ORDER BY YEAR ASC , MONTH ASC";
        $all = $conn->fetchAll($sql);

        //return $this->render('MefiInfoDumpBundle:UserInfo:test.html.twig', array('test'=>'This is a test'));
        $response = new Response(json_encode(array('d1' => array(1,2,3,4))));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function testContentAction()
    {
        return $this->render('MefiInfoDumpBundle:UserInfo:test.html.twig');
    }
}

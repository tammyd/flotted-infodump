<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Connection;


class UserInfoController extends Controller
{
    public function testAction()
    {
//        $cgg = null;
//        $cgg = $this->getDoctrine()
//            ->getRepository('MefiInfoDumpBundle:Usernames')
//            ->findOneBy(array('name' => 'cgg'));
//
//        var_dump($cgg); die();

//        if (!$cgg) {
//            throw $this->createNotFoundException(
//                'No user found for cgg'
//            );
//        }

        /** @var $conn Connection */
        $conn = $this->getDoctrine()
            ->getManager()
            ->getConnection();
        echo get_class($conn);
        $sql = "SELECT COUNT( * ) AS signups, YEAR( joindate ) AS YEAR, MONTH( joindate ) AS MONTH FROM
                usernames  GROUP BY YEAR, MONTH ORDER BY YEAR ASC , MONTH ASC";
        var_dump($conn->fetchAll($sql));


//        $query = $em->createQuery(
//            'SELECT COUNT(*), year(joindate) as year, month() FROM MefiInfoDumpBundle:Usernames');
//
//        $products = $query->getResult();
//        var_dump($products);

        return $this->render('MefiInfoDumpBundle:UserInfo:test.html.twig');
    }
}

<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends Controller
{
    public function indexAction()
    {

        return $this->render('MefiInfoDumpBundle:Pages:home.html.twig');
    }

    public function templateAction()
    {
        return $this->render('MefiInfoDumpBundle:Home:template.html.twig');
    }

    public function contentAction()
    {
        return $this->render('MefiInfoDumpBundle:Home:landing.html.twig');
    }

    public function testerAction($graph) {
        $content_route = "{$graph}_content";
        $data_route = "{$graph}_data";
        return $this->render('MefiInfoDumpBundle:Pages:tester.html.twig', array('content_route'=>$content_route, 'data_route'=>$data_route));
    }
}

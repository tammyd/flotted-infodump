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
}
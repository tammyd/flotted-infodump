<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('MefiInfoDumpBundle:Pages:home.html.twig');
    }
}

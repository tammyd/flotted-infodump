<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CommonController extends Controller
{
    public function headerAction()
    {
        return $this->render('MefiInfoDumpBundle:Common:header.html.twig');
    }

    public function footerAction()
    {
        return $this->render('MefiInfoDumpBundle:Common:footer.html.twig');
    }
}

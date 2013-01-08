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

    public function leftNavAction()
    {

        $usernames = new ChartGroup('Registrations');
        $usernames->addChart('Total By Hour', 'signupsByHour');
        $usernames->addChart('Total By Date', 'signupsByDate');
        $usernames->addChart('Total By Day of Week', 'signupsByDOW');
        $usernames->addChart('Total By Month', 'signupsByMonth');
        $usernames->addChart('Total By Month & Year', 'signupsByMonthYear');
        $usernames->addChart('Total By Year', 'signupsByYear');

        $askmePosts = new ChartGroup('Askme Posts');
        $askmePosts->addChart('Total By Hour', 'askPostsByHour');
        $askmePosts->addChart('Total By Date', 'askPostsByDate');
        $askmePosts->addChart('Total By Day of Week', 'askPostsByDOW');
        $askmePosts->addChart('Total By Month', 'askPostsByMonth');
        $askmePosts->addChart('Total By Month & Year', 'askPostsByMonthYear');
        $askmePosts->addChart('Total By Year', 'askPostsByYear');

        $askmeDeletedPosts = new ChartGroup('Askme Deleted Posts');
        $askmeDeletedPosts->addChart('Total By Hour', 'askDeletedPostsByHour');
        $askmeDeletedPosts->addChart('Total By Date', 'askDeletedPostsByDate');
        $askmeDeletedPosts->addChart('Total By Day of Week', 'askDeletedPostsByDOW');
        $askmeDeletedPosts->addChart('Total By Month', 'askDeletedPostsByMonth');
        $askmeDeletedPosts->addChart('Total By Month & Year', 'askDeletedPostsByMonthYear');
        $askmeDeletedPosts->addChart('Total By Year', 'askDeletedPostsByYear');


        $charts = array($usernames, $askmePosts, $askmeDeletedPosts);

        return $this->render('MefiInfoDumpBundle:Common:leftnav.html.twig', array('chart_groups'=>$charts));
    }
}

class DisplayChart {
    public $text;
    public $key;
    public function __construct($text, $key) {
        $this->text = $text;
        $this->key = $key;
    }
}

class ChartGroup {
    public $name;
    protected $charts = array();

    public function __construct($name) {
        $this->name = $name;
    }

    public function addChart($text, $key) {
        $chart = new DisplayChart($text, $key);
        $this->charts[] = $chart;
    }
    public function getCharts() {
        return $this->charts;
    }
}

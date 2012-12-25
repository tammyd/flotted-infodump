<?php

namespace Mefi\InfoDumpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;



class JsonDataController extends Controller
{

    protected function jsonResponse($data) {

        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
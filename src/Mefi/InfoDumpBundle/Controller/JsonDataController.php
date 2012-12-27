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

    protected function normalize1DData($data, $default=0) {
        $keys = range(min(array_keys($data)), max(array_keys($data)));

        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                $data[$key] = $default;
            }
        }
        ksort($data);

        return $data;
    }

    protected function normalize2DData($data, $default=0) {


        $data = $this->normalize1DData($data, array());
        $keys = range(min(array_keys($data)), max(array_keys($data)));

        $minKey = null; $maxKey = null;
        foreach ($keys as $key) {
            if (!empty($data[$key])) {
                $min = min(array_keys($data[$key]));
                $max = max(array_keys($data[$key]));
                $minKey = is_null($minKey) ? $min : min($min, $minKey);
                $maxKey = is_null($maxKey) ? $max : max($max, $maxKey);
            }
        }

        foreach ($keys as $key) {
            foreach (range($minKey, $maxKey) as $i) {
                if (!isset($data[$key][$i])) {
                    $data[$key][$i] = $default;
                }
            }
            ksort($data[$key]);
        }

        return $data;

    }

}
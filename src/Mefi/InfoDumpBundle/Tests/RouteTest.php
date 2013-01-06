<?php

namespace Mefi\InfoDumpBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteTest extends WebTestCase
{

    private $dataUrls = array();
    private $contentUrls = array();
    private $client;
    private $container;

    protected function setup() {

        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $routes = $this->container->get('router')->getRouteCollection()->all();
        foreach ($routes as $route) {
            $pattern = $route->getPattern();
            if (preg_match('/\/data$/', $pattern)) {
                $this->dataUrls[] = $pattern;
            }
            if (preg_match('/\/content/', $pattern)) {
                $this->contentUrls[] = $pattern;
            }
        }

    }

    public function testRouteList() {
        $this->assertGreaterThan(0, count($this->dataUrls));
        $this->assertGreaterThan(0, count($this->contentUrls));
    }

    public function testDataRoutes() {

        foreach ($this->dataUrls as $path) {
            $crawler = $this->client->request('GET', $path);
            $response = $this->client->getResponse();
            $this->assertTrue($response->isSuccessful(), "$path request was not successful.");
            $this->assertEquals(
                200,
                $response->getStatusCode(),
                "$path did not return 200 status code."
            );
            $this->assertEquals('application/json', $response->headers->get('content-type'), "Invalid content type from $path.");
        }
    }

    public function testContentRoutes() {

        foreach ($this->contentUrls as $path) {
            $crawler = $this->client->request('GET', $path);
            $response = $this->client->getResponse();
            $this->assertTrue($response->isSuccessful(), "$path request was not successful.");
            $this->assertEquals(
                200,
                $response->getStatusCode(),
                "$path did not return 200 status code."
            );
            $this->assertEquals('text/html; charset=UTF-8', $response->headers->get('content-type'), "Invalid content type from $path.");
        }
    }

}

<?php

namespace Tests\Common\Controller;

use Symfony\Component\HttpFoundation\Request;

class BaseWebApiTestCase extends BaseWebTestCase
{
    public function getRequestJson($url, $parameters = [], $files = [], $server = [])
    {
        $server['CONTENT_TYPE'] = 'application/json';
        $server['HTTP_ACCEPT'] = 'application/json';

        $crawler = $this->client->request(Request::METHOD_GET, $url, $parameters, $files, $server);

        return $this->client->getResponse();
    }

    public function postRequestJson($url, $body = [], $files = [], $server = [])
    {
        $server['CONTENT_TYPE'] = 'application/json';
        $server['HTTP_ACCEPT'] = 'application/json';
        $this->client->request(Request::METHOD_POST, $url, [], $files, $server, json_encode($body));
        return $this->client->getResponse();
    }

    public function putRequestJson($url, $body = [])
    {
        $server = [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json'
        ];

        $this->client->request(Request::METHOD_PUT, $url, [], [], $server, json_encode($body));

        return $this->client->getResponse();
    }

    public function deleteJsonRequest($url)
    {
        $server = [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json'
        ];

        $this->client->request(Request::METHOD_DELETE, $url, [], [], $server);

        return $this->client->getResponse();
    }
}
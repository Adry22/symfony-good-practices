<?php

namespace Tests\Common\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Universe\User\Entity\User;

class BaseWebApiTestCase extends BaseWebTestCase
{
    public function getRequestJson($url, $parameters = [], $files = [], $server = []): Response
    {
        $server['CONTENT_TYPE'] = 'application/json';
        $server['HTTP_ACCEPT'] = 'application/json';

        $this->client->request(Request::METHOD_GET, $url, $parameters, $files, $server);

        return $this->client->getResponse();
    }

    public function postRequestJson($url, $body = [], $files = [], $server = []): Response
    {
        $server['CONTENT_TYPE'] = 'application/json';
        $server['HTTP_ACCEPT'] = 'application/json';
        $this->client->request(Request::METHOD_POST, $url, [], $files, $server, json_encode($body));
        return $this->client->getResponse();
    }

    public function putRequestJson($url, $body = []): Response
    {
        $server = [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json'
        ];

        $this->client->request(Request::METHOD_PUT, $url, [], [], $server, json_encode($body));

        return $this->client->getResponse();
    }

    public function deleteJsonRequest($url): Response
    {
        $server = [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json'
        ];

        $this->client->request(Request::METHOD_DELETE, $url, [], [], $server);

        return $this->client->getResponse();
    }

    protected function loginUser(User $user): void
    {
        $this->client->loginUser($user);
    }
}
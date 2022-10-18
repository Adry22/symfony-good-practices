<?php

namespace Tests\Universe\User\Controller;

use Symfony\Component\HttpFoundation\Response;
use Tests\Common\Controller\BaseWebApiTestCase;
use Universe\User\Repository\UserRepository;

class RegisterUserControllerTest extends BaseWebApiTestCase
{
    private const URL = '/register-user';

    private UserRepository $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->testContainer->get(UserRepository::class);
    }

    /** @test */
    public function should_exists_url(): void
    {
        $parameters = ['email' => 'email@test.com', 'password' => 'password'];

        $response = $this->getRequestJson(self::URL, $parameters);

        $this->assertNotEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /** @test */
    public function should_create_user(): void
    {
        $parameters = ['email' => 'email@test.com', 'password' => 'password'];

        $this->getRequestJson(self::URL, $parameters);

        $users = $this->userRepository->findAll();

        $this->assertCount(1, $users);
        $this->assertEquals('email@test.com', $users[0]->email());
    }
}
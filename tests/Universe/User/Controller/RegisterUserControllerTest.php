<?php
declare(strict_types=1);
namespace Tests\Universe\User\Controller;

use Symfony\Component\HttpFoundation\Response;
use Tests\Common\Builder\User\UserBuilder;
use Tests\Common\Controller\BaseWebApiTestCase;
use Universe\User\Repository\UserRepositoryInterface;

class RegisterUserControllerTest extends BaseWebApiTestCase
{
    private const URL = '/register-user';

    private UserRepositoryInterface $userRepository;
    private UserBuilder $userBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->testContainer->get(UserRepositoryInterface::class);
        $this->userBuilder = new UserBuilder($this->entityManager);
    }

    /** @test */
    public function should_exists_url(): void
    {
        $parameters = ['email' => 'email@test.com', 'password' => 'password'];

        $response = $this->getRequestJson(self::URL, $parameters);

        $this->assertNotEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /** @test */
    public function given_email_to_register_user_when_email_already_exists_then_fail(): void
    {
        $this->userBuilder
            ->withEmail('email@test.com')
            ->withPassword('password')
            ->build();

        $parameters = ['email' => 'email@test.com', 'password' => 'password'];

        $response = $this->getRequestJson(self::URL, $parameters);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals(400, $response['code']);
        $this->assertEquals('User email already exists', $response['message']);
        $this->assertEquals('UserEmailAlreadyExistsException', $response['type']);
    }

    /** @test */
    public function given_user_to_register_when_everything_is_ok_then_create_user(): void
    {
        $parameters = ['email' => 'email@test.com', 'password' => 'password'];

        $this->getRequestJson(self::URL, $parameters);

        $users = $this->userRepository->findAll();

        $this->assertCount(1, $users);
        $this->assertEquals('email@test.com', $users[0]->email());
    }
}
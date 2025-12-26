<?php

declare(strict_types=1);

namespace User\Infrastructure\Controller;

use Shared\Domain\ValueObject\Email;
use Symfony\Component\HttpFoundation\Response;
use Tests\Common\Controller\BaseWebApiTestCase;
use User\Domain\Entity\User\Password\Password;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Repository\UserRepositoryInterface;

class RegisterUserControllerTest extends BaseWebApiTestCase
{
    private const URL = '/register-user/{uuid}';

    private UserRepositoryInterface $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->testContainer->get(UserRepositoryInterface::class);
    }

    /** @test */
    public function should_exists_url(): void
    {
        $parameters = ['email' => 'email@test.com', 'password' => 'password'];

        $response = $this->postRequestJson($this->generateUrl(UserId::random()->toString()), $parameters);

        $this->assertNotEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /** @test */
    public function given_email_to_register_user_when_email_already_exists_then_fail(): void
    {
        $user = $this->builderFactory()->user()
            ->withEmail(new Email('email@test.com'))
            ->withPassword(new Password('password'))
            ->build();

        $this->userRepository->save($user);
        $this->userRepository->flush();

        $parameters = ['email' => 'email@test.com', 'password' => 'password'];

        $response = $this->postRequestJson($this->generateUrl(UserId::random()->toString()), $parameters);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals(400, $response['code']);
        $this->assertEquals('User email already exists', $response['message']);
        $this->assertEquals('UserEmailAlreadyExistsException', $response['type']);
    }

    /** @test */
    public function given_user_to_register_when_everything_is_ok_then_create_user(): void
    {
        $parameters = [
            'email' => 'email@test.com',
            'password' => 'password',
            'street' => 'Street',
            'number' => '2',
            'city' => 'Madrid',
            'country' => 'España',
        ];

        $this->postRequestJson($this->generateUrl(UserId::random()->toString()), $parameters);

        $users = $this->userRepository->findAll();

        $this->assertCount(1, $users);
        $this->assertEquals('email@test.com', $users[0]->email());
    }

    /** @test */
    public function given_user_to_register_when_everything_is_ok_then_send_welcome_email(): void
    {
        $this->client->enableProfiler();

        $parameters = [
            'email' => 'email@test.com',
            'password' => 'password',
            'street' => 'Street',
            'number' => '2',
            'city' => 'Madrid',
            'country' => 'España',
        ];

        $this->postRequestJson($this->generateUrl(UserId::random()->toString()), $parameters);

        $mailCollector = $this->client->getProfile()->getCollector('mailer');
        $messages = $mailCollector->getEvents()->getMessages();
        $this->assertCount(1, $messages);

        /** @var Email $message */
        $message = $messages[0];

        $this->assertSame('email@test.com', $message->getTo()[0]->getAddress());
        $this->assertSame('good-practices@symfonyproject.com', $message->getFrom()[0]->getAddress());
    }

    private function generateUrl(string $uuid): string
    {
        return str_replace('{uuid}', $uuid, self::URL);
    }
}
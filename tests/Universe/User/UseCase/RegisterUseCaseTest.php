<?php

namespace Tests\Universe\User\UseCase;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Tests\Common\Builder\User\UserBuilder;
use Tests\Common\Controller\BaseWebTestCase;
use Universe\Shared\Mailer\MailtrapEmailSender;
use Universe\User\Exception\UserEmailAlreadyExistsException;
use Universe\User\Repository\UserRepository;
use Universe\User\UseCase\RegisterUserUseCase;

class RegisterUseCaseTest extends BaseWebTestCase
{
    private UserRepository $userRepository;
    private RegisterUserUseCase $registerUserUseCase;
    private MailtrapEmailSender $mailtrapEmailSender;
    private UserPasswordHasherInterface $userPasswordHasherInterface;
    private UserBuilder $userBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->testContainer->get(UserRepository::class);
        $this->mailtrapEmailSender = $this->testContainer->get(MailtrapEmailSender::class);
        $this->userPasswordHasherInterface = $this->testContainer->get(UserPasswordHasherInterface::class);

        $this->userBuilder = new UserBuilder($this->entityManager);

        $this->registerUserUseCase = new RegisterUserUseCase(
            $this->userRepository,
            $this->mailtrapEmailSender,
            $this->userPasswordHasherInterface
        );
    }

    /** @test */
    public function given_email_to_register_user_when_email_already_exists_then_fail(): void
    {
        $this->expectException(UserEmailAlreadyExistsException::class);

        $this->userBuilder
            ->withEmail('email@test.com')
            ->withPassword('password')
            ->build();

        $this->registerUserUseCase->handle('email@test.com', 'password');
    }

    /** @test */
    public function given_user_to_register_when_everything_is_ok_then_create_user(): void
    {
        $this->registerUserUseCase->handle('email@test.com', 'password');

        $users = $this->userRepository->findAll();

        $this->assertCount(1, $users);
        $this->assertEquals('email@test.com', $users[0]->email());
    }
}
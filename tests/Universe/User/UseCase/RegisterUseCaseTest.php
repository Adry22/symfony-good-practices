<?php

namespace Tests\Universe\User\UseCase;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Tests\Common\Controller\BaseWebTestCase;
use Universe\Shared\Mailer\MailtrapEmailSender;
use Universe\User\Repository\UserRepository;
use Universe\User\UseCase\RegisterUserUseCase;

class RegisterUseCaseTest extends BaseWebTestCase
{
    private UserRepository $userRepository;
    private RegisterUserUseCase $registerUserUseCase;
    private MailtrapEmailSender $mailtrapEmailSender;
    private UserPasswordHasherInterface $userPasswordHasherInterface;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->testContainer->get(UserRepository::class);
        $this->mailtrapEmailSender = $this->testContainer->get(MailtrapEmailSender::class);
        $this->userPasswordHasherInterface = $this->testContainer->get(UserPasswordHasherInterface::class);

        $this->registerUserUseCase = new RegisterUserUseCase(
            $this->userRepository,
            $this->mailtrapEmailSender,
            $this->userPasswordHasherInterface
        );
    }

    /** @test */
    public function should_create_user(): void
    {
        $this->registerUserUseCase->handle('email@test.com', 'password');

        $users = $this->userRepository->findAll();

        $this->assertCount(1, $users);
        $this->assertEquals('email@test.com', $users[0]->email());
    }
}
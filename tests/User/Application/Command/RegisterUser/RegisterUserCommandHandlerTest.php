<?php

declare(strict_types=1);

namespace User\Application\Command\RegisterUser;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Tests\Common\Builder\User\UserBuilder;
use Tests\Common\Controller\BaseWebTestCase;
use Universe\Shared\Mailer\MailtrapEmailSender;
use User\Domain\Repository\UserRepositoryInterface;

class RegisterUserCommandHandlerTest extends BaseWebTestCase
{
    private UserRepositoryInterface $userRepository;
    private RegisterUserCommandHandler $registerUserCommandHandler;
    private MailtrapEmailSender $mailtrapEmailSender;
    private UserPasswordHasherInterface $userPasswordHasherInterface;
    private UserBuilder $userBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->testContainer->get(UserRepositoryInterface::class);
        $this->mailtrapEmailSender = $this->testContainer->get(MailtrapEmailSender::class);
        $this->userPasswordHasherInterface = $this->testContainer->get(UserPasswordHasherInterface::class);

        $this->userBuilder = new UserBuilder($this->entityManager);

        $this->registerUserCommandHandler = new RegisterUserCommandHandler(
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

        $command = new RegisterUserCommand('email@test.com', 'password');
        $this->registerUserCommandHandler->handle($command);
    }

    /** @test */
    public function given_user_to_register_when_everything_is_ok_then_create_user(): void
    {
        $command = new RegisterUserCommand(
            'email@test.com',
            'password',
            'street',
            'number',
            'Madrid',
            'country'
        );

        $this->registerUserCommandHandler->handle($command);
        $this->entityManager->flush();

        $users = $this->userRepository->findAll();

        $this->assertCount(1, $users);
        $this->assertEquals('email@test.com', $users[0]->email());
    }
}
<?php

declare(strict_types=1);

namespace User\Application\Command\RegisterUser;

use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Tests\Common\Builder\BuilderFactory;
use User\Domain\Entity\User\Password\Password;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Repository\UserRepositoryInterface;

class RegisterUserCommandHandlerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->userPasswordHasherInterface = $this->createMock(UserPasswordHasherInterface::class);

        $this->builderFactory = new BuilderFactory();

        $this->registerUserCommandHandler = new RegisterUserCommandHandler(
            $this->userRepository,
            $this->userPasswordHasherInterface
        );
    }

    /** @test */
    public function given_email_to_register_user_when_email_already_exists_then_fail(): void
    {
        $this->expectException(UserEmailAlreadyExistsException::class);

        $user = $this->builderFactory->user()
            ->withEmail(new Email('email@test.com'))
            ->withPassword(new Password('password'))
            ->build();

        $this->userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->willReturn($user);

        $command = new RegisterUserCommand(UserId::random()->toString(), 'email@test.com', 'password');
        $this->registerUserCommandHandler->handle($command);
    }

    /** @test */
    public function given_user_to_register_when_everything_is_ok_then_create_user(): void
    {
        $userId = UserId::random();

        $command = new RegisterUserCommand($userId->toString(), 'email@test.com', 'password');

        $this->userRepository
            ->expects($this->once())
            ->method('save');

        $this->userPasswordHasherInterface
            ->expects($this->once())
            ->method('hashPassword')
            ->willReturn('password');

        $user = $this->registerUserCommandHandler->handle($command);

        $this->assertSame('email@test.com', $user->email()->toString());

        $events = $user->pullEvents();
        $this->assertCount(1, $events);
        $this->assertSame('user.registered', $events[0]::name());
    }
}
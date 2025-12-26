<?php

declare(strict_types=1);

namespace User\Application\Command\UpdateProfileUser;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\Email;
use Tests\Common\Builder\BuilderFactory;
use User\Domain\Entity\User\Address\Address;
use User\Domain\Entity\User\Password\Password;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Entity\User\UserNotFoundException;
use User\Domain\Repository\UserRepositoryInterface;

class UpdateProfileUserCommandHandlerTest extends TestCase
{
    private UserRepositoryInterface&MockObject $userRepository;
    private BuilderFactory $builderFactory;
    private UpdateProfileUserCommandHandler $commandHandler;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepositoryInterface::class);

        $this->builderFactory = new BuilderFactory();

        $this->commandHandler = new UpdateProfileUserCommandHandler($this->userRepository);
    }

    /** @test */
    public function should_fail_when_user_not_found(): void
    {
        $this->expectException(UserNotFoundException::class);

        $command = new UpdateProfileUserCommand(
            userId: UserId::random()->toString(),
            street: 'New Street',
            number: '123',
            city: 'Madrid',
            country: 'New Country',
            name: 'New Name'
        );

        $this->userRepository
            ->expects($this->once())
            ->method('findByIdOrFail')
            ->willThrowException(new UserNotFoundException());

        $this->commandHandler->handle($command);
    }

    /** @test */
    public function should_update_profile_when_everything_is_correct(): void
    {
        $userProfile = $this->builderFactory->userProfile()
            ->withAddress(new Address('Old Street', '456', 'Barcelona', 'Old Country'))
            ->withName('Old name')
            ->build();

        $user = $this->builderFactory->user()
            ->withEmail(new Email('email@test.com'))
            ->withPassword(Password::fromString('password'))
            ->withProfile($userProfile)
            ->build();

        $command = new UpdateProfileUserCommand(
            userId: $user->id()->toString(),
            street: 'New Street',
            number: '123',
            city: 'Madrid',
            country: 'New Country',
            name: 'New Name'
        );

        $this->userRepository
            ->expects($this->once())
            ->method('findByIdOrFail')
            ->willReturn($user);

        $this->commandHandler->handle($command);

        $this->assertSame('New Street 123, Madrid, New Country', $user->profile()->address()->toString());
        $this->assertSame('New Name', $user->profile()->name());
    }

    /** @test */
    public function should_publish_user_name_changed_event(): void
    {
        $userProfile = $this->builderFactory->userProfile()
            ->withName('Old Name')
            ->build();

        $user = $this->builderFactory->user()
            ->withEmail(new Email('email@test.com'))
            ->withPassword(Password::fromString('password'))
            ->withProfile($userProfile)
            ->build();

        $command = new UpdateProfileUserCommand(
            userId: $user->id()->toString(),
            name: 'New Name'
        );

        $this->userRepository
            ->expects($this->once())
            ->method('findByIdOrFail')
            ->willReturn($user);

        $this->commandHandler->handle($command);

        $events = $user->pullEvents();

        $this->assertCount(1, $events);

        $event = $events[0];

        $this->assertSame('user.name_changed', $event::name());

        $this->assertSame($user->id()->toString(), $event->userId());
        $this->assertSame('New Name', $event->newName());
    }

    /** @test */
    public function should_publish_user_address_changed_event(): void
    {
        $userProfile = $this->builderFactory->userProfile()
            ->withName('Same Name')
            ->withAddress(new Address('Old Street', '1', 'Barcelona', 'Spain'))
            ->build();

        $user = $this->builderFactory->user()
            ->withEmail(new Email('email@test.com'))
            ->withPassword(Password::fromString('password'))
            ->withProfile($userProfile)
            ->build();

        $command = new UpdateProfileUserCommand(
            userId: $user->id()->toString(),
            street: 'New Street',
            number: '99',
            city: 'Valencia',
            country: 'Spain',
            name: 'Same Name'
        );

        $this->userRepository
            ->expects($this->once())
            ->method('findByIdOrFail')
            ->willReturn($user);

        $this->commandHandler->handle($command);

        $events = $user->pullEvents();

        $this->assertCount(1, $events);

        $event = $events[0];

        $this->assertSame('user.address_changed', $event::name());

        $this->assertSame($user->id()->toString(), $event->userId());
        $this->assertSame('New Street', $event->street());
        $this->assertSame('99', $event->number());
        $this->assertSame('Valencia', $event->city());
    }
}

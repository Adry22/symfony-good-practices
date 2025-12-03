<?php

declare(strict_types=1);

namespace User\Application\Command\UpdateProfileUser;

use Monolog\Test\TestCase;
use Tests\Common\Builder\BuilderFactory;
use User\Domain\Entity\User\Address\Address;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Entity\User\UserNotFoundException;
use User\Domain\Repository\UserRepositoryInterface;

class UpdateProfileUserCommandHandlerTest extends TestCase
{
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
            ->withEmail('email@test.com')
            ->withPassword('password')
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
}

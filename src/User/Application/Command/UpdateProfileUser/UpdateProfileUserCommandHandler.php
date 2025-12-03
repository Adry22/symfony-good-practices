<?php

declare(strict_types=1);

namespace User\Application\Command\UpdateProfileUser;

use Shared\Domain\Bus\Command\CommandHandler;
use User\Domain\Entity\User\Address\AddressInvalidArgumentException;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Entity\User\UserId\UserIdInvalidArgumentException;
use User\Domain\Entity\User\UserNotFoundException;
use User\Domain\Repository\UserRepositoryInterface;

class UpdateProfileUserCommandHandler implements CommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @throws AddressInvalidArgumentException
     * @throws UserNotFoundException
     * @throws UserIdInvalidArgumentException
     */
    public function handle(UpdateProfileUserCommand $command): void
    {
        $user = $this->userRepository->findByIdOrFail(UserId::fromString($command->userId()));

        $user->updateProfile(
            street: $command->street(),
            number: $command->number(),
            city: $command->city(),
            country: $command->country(),
            name: $command->name()
        );

        $this->userRepository->save($user);
    }
}
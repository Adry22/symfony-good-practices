<?php

namespace User\Application\Command\RegisterUser;

use Shared\Domain\Bus\Command\CommandHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use User\Domain\Entity\User\User;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Entity\User\UserId\UserIdInvalidArgumentException;
use User\Domain\Exception\UserMailNotValidException;
use User\Domain\Repository\UserRepositoryInterface;

class RegisterUserCommandHandler implements CommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    /**
     * @throws UserEmailAlreadyExistsException
     * @throws UserMailNotValidException
     * @throws UserIdInvalidArgumentException
     */
    public function handle(RegisterUserCommand $command): User
    {
        $this->checkEmailNotExists($command->email());

        $user = User::create(UserId::fromString($command->uuid()), $command->email());
        $this->hashPassword($user, $command->password());

        $this->userRepository->save($user);

        return $user;
    }

    /**
     * @throws UserEmailAlreadyExistsException
     */
    private function checkEmailNotExists(string $email): void
    {
        $emailAlreadyExists = $this->userRepository->findByEmail($email);

        if ($emailAlreadyExists) {
            throw new UserEmailAlreadyExistsException();
        }
    }

    private function hashPassword(User $user, string $password): void {
        $passwordHashed = $this->userPasswordHasher->hashPassword($user, $password);

        // TODO: setPassword shouldnt exists, should set password when create user
        $user->setPassword($passwordHashed);
    }
}
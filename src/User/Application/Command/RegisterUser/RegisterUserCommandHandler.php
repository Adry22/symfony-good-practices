<?php

namespace User\Application\Command\RegisterUser;

use Shared\Domain\Bus\Command\CommandHandler;
use Shared\Domain\ValueObject\Address\Address;
use Shared\Domain\ValueObject\Address\AddressCityIsNotValidException;
use Shared\Infrastructure\Mailer\MailtrapEmailSender;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use User\Domain\Entity\User;
use User\Domain\Exception\UserMailNotValidException;
use User\Domain\Repository\UserRepositoryInterface;

class RegisterUserCommandHandler implements CommandHandler
{
    private UserRepositoryInterface $userRepository;
    private MailtrapEmailSender $emailSender;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        UserRepositoryInterface $userRepository,
        MailtrapEmailSender $emailSender,
        UserPasswordHasherInterface $userPasswordHasher
    ) {
        $this->userRepository = $userRepository;
        $this->emailSender = $emailSender;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws UserEmailAlreadyExistsException
     * @throws UserMailNotValidException|AddressCityIsNotValidException
     */
    public function handle(RegisterUserCommand $command): void
    {
        $this->checkEmailNotExists($command->email());

        $address = new Address(
            $command->street(),
            $command->number(),
            $command->city(),
            $command->country()
        );

        $user = User::create($command->email(), $address);
        $this->hashPassword($user, $command->password());
        $this->userRepository->save($user);

        $this->emailSender->sendTo($user->email());
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
        $user->setPassword($passwordHashed);
    }
}
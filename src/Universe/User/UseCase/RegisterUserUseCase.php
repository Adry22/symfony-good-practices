<?php

namespace Universe\User\UseCase;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Universe\Shared\Mailer\MailtrapEmailSender;
use Universe\User\Entity\User;
use Universe\User\Exception\UserEmailAlreadyExistsException;
use Universe\User\Exception\UserMailNotValidException;
use Universe\User\Repository\UserRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Doctrine\ORM\NonUniqueResultException;

class RegisterUserUseCase
{
    private UserRepository $userRepository;
    private MailtrapEmailSender $emailSender;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        UserRepository $userRepository,
        MailtrapEmailSender $emailSender,
        UserPasswordHasherInterface $userPasswordHasher
    )
    {
        $this->userRepository = $userRepository;
        $this->emailSender = $emailSender;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @throws NonUniqueResultException
     * @throws TransportExceptionInterface
     * @throws UserEmailAlreadyExistsException
     * @throws UserMailNotValidException
     */
    public function handle(string $email, string $password): void
    {
        $this->checkEmailNotExists($email);

        $user = User::create($email);
        $this->hashPassword($user, $password);
        $this->userRepository->save($user);
        $this->userRepository->flush();

        $this->emailSender->sendTo($user->email());
    }

    /**
     * @throws NonUniqueResultException
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
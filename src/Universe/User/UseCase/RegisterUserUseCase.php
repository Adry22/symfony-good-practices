<?php

namespace Universe\User\UseCase;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Universe\Shared\Mailer\MailtrapEmailSender;
use Universe\User\Entity\User;
use Universe\User\Exception\UserMailNotValidException;
use Universe\User\Repository\UserRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

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
     * @throws TransportExceptionInterface
     * @throws UserMailNotValidException
     */
    public function handle(string $email, string $password): void
    {
        $user = User::create($email);
        $this->hashPassword($user, $password);
        $this->userRepository->save($user);
        $this->userRepository->flush();

        $this->emailSender->sendTo($user->email());
    }

    private function hashPassword(User $user, string $password): void {
        $passwordHashed = $this->userPasswordHasher->hashPassword($user, $password);
        $user->setPassword($passwordHashed);
    }
}
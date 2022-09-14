<?php

namespace Universe\User\UseCase;

use Universe\Shared\Mailer\MailtrapEmailSender;
use Universe\User\Entity\User;
use Universe\User\Exception\UserMailNotValidException;
use Universe\User\Repository\UserRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class RegisterUserUseCase
{
    private UserRepository $userRepository;
    private MailtrapEmailSender $emailSender;

    public function __construct(
        UserRepository $userRepository,
        MailtrapEmailSender $emailSender
    )
    {
        $this->userRepository = $userRepository;
        $this->emailSender = $emailSender;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws UserMailNotValidException
     */
    public function handle(?string $email = null): void
    {
        $user = User::create($email);
        $this->userRepository->save($user);
        $this->userRepository->flush();

        $this->emailSender->sendTo($user->email());
    }
}
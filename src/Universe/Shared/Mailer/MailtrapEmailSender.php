<?php
declare(strict_types=1);

namespace Universe\Shared\Mailer;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailtrapEmailSender
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendTo(string $email): void
    {
        $email = (new Email())
            ->from('good-practices@symfonyproject.com')
            ->to($email)
            ->subject('Email subject')
            ->html('<p>Email content</p>');

        $this->mailer->send($email);
    }
}
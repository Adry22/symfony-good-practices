<?php

declare(strict_types=1);

namespace User\Application\EventListener;

use Shared\Infrastructure\Mailer\MailtrapEmailSender;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use User\Domain\Event\UserRegistered;

final class SendEmailOnUserRegistered implements EventSubscriberInterface
{
    public function __construct(private MailtrapEmailSender $emailSender)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserRegistered::name() => 'onUserRegistered',
        ];
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function onUserRegistered(UserRegistered $event): void
    {
        $this->emailSender->sendTo($event->email());
    }
}
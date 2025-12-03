<?php

declare(strict_types=1);

namespace User\Application\EventListener;

use Monolog\Test\TestCase;
use Shared\Infrastructure\Mailer\MailtrapEmailSender;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Event\UserRegistered;

final class SendEmailOnUserRegisteredTest extends TestCase
{
    private MailtrapEmailSender $emailSender;
    private SendEmailOnUserRegistered $listener;

    protected function setUp(): void
    {
        parent::setUp();

        $this->emailSender = $this->createMock(MailtrapEmailSender::class);
        $this->listener = new SendEmailOnUserRegistered($this->emailSender);
    }

    /** @test */
    public function should_subscribe_to_user_registered_event(): void
    {
        $subscribedEvents = SendEmailOnUserRegistered::getSubscribedEvents();

        $this->assertArrayHasKey('user.registered', $subscribedEvents);
        $this->assertSame('onUserRegistered', $subscribedEvents['user.registered']);
    }

    /** @test */
    public function should_send_email_when_user_registered(): void
    {
        $event = new UserRegistered(
            UserId::random()->toString(),
            'test@example.com'
        );

        $this->emailSender
            ->expects($this->once())
            ->method('sendTo')
            ->with('test@example.com');

        $this->listener->onUserRegistered($event);
    }
}

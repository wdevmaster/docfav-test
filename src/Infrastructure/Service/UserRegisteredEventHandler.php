<?php

namespace App\Infrastructure\Service;

use App\Domain\Event\UserRegisteredEvent;
use Psr\EventDispatcher\ListenerProviderInterface;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class UserRegisteredEventHandler implements ListenerProviderInterface
{
    private $listeners = [];
    private $logger;

    public function __construct()
    {
        $this->logger = (new Logger('UserRegisteredEvent'))->pushHandler(new StreamHandler(__DIR__ . '/../../../event.log', Logger::DEBUG));
        $this->listeners[UserRegisteredEvent::class][] = [$this, 'onUserRegistered'];
    }

    public function getListenersForEvent(object $event): iterable
    {
        $eventType = get_class($event);
        return $this->listeners[$eventType] ?? [];
    }

    public function onUserRegistered(UserRegisteredEvent $event): void
    {
        $user = $event->getUser();
        $this->sendWelcomeEmail($user->getEmail()->getValue(), $user->getName()->getValue());
    }

    private function sendWelcomeEmail(string $email, string $name): void
    {
        $this->logger->info("Sending welcome email to $email with the name $name.");
    }
}
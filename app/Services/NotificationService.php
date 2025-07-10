<?php

namespace App\Services;

use App\Services\Contracts\NotificationInterface;
use InvalidArgumentException;

class NotificationService
{
   protected array $drivers = [];
    protected string $defaultDriver = 'email';

    public function __construct(array $drivers = [])
    {
        $this->drivers = $drivers;
    }

    public function driver(?string $driver = null): NotificationInterface
    {
        $driver = $driver ?: $this->defaultDriver;

        if (!isset($this->drivers[$driver])) {
            throw new InvalidArgumentException("Driver [{$driver}] not supported.");
        }

        return $this->drivers[$driver];
    }

    public function send(string $message, string $recipient, ?string $driver = null): bool
    {
        return $this->driver($driver)->send($message, $recipient);
    }

    public function addDriver(string $name, NotificationInterface $driver): void
    {
        $this->drivers[$name] = $driver;
    }

    public function getAvailableDrivers(): array
    {
        return array_keys($this->drivers);
    }

    public function setDefaultDriver(string $driver): void
    {
        $this->defaultDriver = $driver;
    } 
}
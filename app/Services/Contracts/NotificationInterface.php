<?php
namespace App\Services\Contracts;

interface NotificationInterface
{
    public function send(string $message, string $recipient): bool;
    public function getType(): string;
}
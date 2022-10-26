<?php
declare(strict_types=1);
namespace Universe\Shared\Bus\Command;

use DateTime;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

abstract class Command
{
    protected string $id;
    protected array $data;
    protected DateTimeImmutable $createdAt;

    protected function __construct(array $data)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->data = $data;
        $this->createdAt = new \DateTimeImmutable();
    }

    final public function id(): string
    {
        return $this->id;
    }

    final public function commandName(): string
    {
        return get_class($this);
    }

    final public function data(): array
    {
        return $this->data;
    }

    final public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    final public function toPayload(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->commandName(),
            'data' => $this->data,
            'createdAt' => $this->createdAt->format(DateTime::ATOM)
        ];
    }
}
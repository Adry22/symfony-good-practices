<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Query;

use DateTime;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

abstract class Query
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

    final public function queryName(): string
    {
        return get_class($this);
    }

    final public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    final public function toPayload(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->queryName(),
            'data' => $this->data,
            'createdAt' => $this->createdAt->format(DateTime::ATOM)
        ];
    }
}
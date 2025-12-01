<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Command;

use Shared\Infrastructure\Bus\Command\Command;

interface CommandBus
{
    public function handle(Command $command): void;
}
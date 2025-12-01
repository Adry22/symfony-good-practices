<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Command;

use League\Tactician\CommandBus as TacticianBus;
use Shared\Domain\Bus\Command\CommandBus;

class TacticianCommandBus implements CommandBus
{
    private TacticianBus $commandBus;

    public function __construct(TacticianBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(Command $command): void
    {
        $this->commandBus->handle($command);
    }
}
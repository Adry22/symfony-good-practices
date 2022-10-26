<?php
declare(strict_types=1);
namespace Universe\Shared\Bus\Command;

use League\Tactician\CommandBus as TacticianBus;

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
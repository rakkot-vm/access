<?php

declare(strict_types=1);

namespace App\Service;

use App\Command\CheckAccessCommand;

// There we are checking and launching the command
class CommandService
{
    //TODO: this const should be change to some config where we can register commands(/conf/commands.yaml for example)
    private const array COMMAND_MAPPING = [
        'has-access' => CheckAccessCommand::class,
    ];

    public function __construct(private $container) {
    }

    public function isCommandExists(string $commandName): bool
    {
        return array_key_exists($commandName, self::COMMAND_MAPPING);
    }

    public function execute(array $argc): mixed
    {
        //also somewhere here should be check is args enough for command
        $command = $this->container->get(self::COMMAND_MAPPING[$argc[1]]);

        return $command->execute($argc);
    }
}

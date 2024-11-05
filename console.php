#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Service\CommandService;
use DI\ContainerBuilder;
use App\Db\Database;
use App\Repository\UserRepository;
use App\Repository\FunctionRepository;
use App\Service\AccessService;
use App\Command\CheckAccessCommand;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    Database::class => DI\create(Database::class),
    UserRepository::class => DI\create(UserRepository::class)->constructor(DI\get(Database::class)),
    FunctionRepository::class => DI\create(FunctionRepository::class)->constructor(DI\get(Database::class)),
    AccessService::class => DI\create(AccessService::class)
        ->constructor(
            DI\get(UserRepository::class),
            DI\get(FunctionRepository::class)
        ),
    CheckAccessCommand::class => DI\create(CheckAccessCommand::class)
        ->constructor(DI\get(AccessService::class))
]);

$container = $containerBuilder->build();

$commandService = new CommandService($container);

if (!empty($argv[1]) && $commandService->isCommandExists($argv[1])) {
    $commandService->execute($argv);
} else {
    echo "Command not found!\n";
    exit(1);
}

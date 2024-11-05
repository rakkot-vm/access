<?php

declare(strict_types=1);

namespace App\Command;

use App\Command\Interface\Command;
use App\Service\AccessService;

class CheckAccessCommand implements Command
{
    private AccessService $accessService;

    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }

    public function execute(array $args): bool
    {
        $this->validateArgs($args);

        $username = $args[2];
        $functionName = $args[3];

        return $this->accessService->checkAccess($username, $functionName);
    }

    private function validateArgs(array $args): void
    {
        if (count($args) !== 4) {
            echo "Usage: has-access username functionname\n";
            exit(1);
        }
    }
}

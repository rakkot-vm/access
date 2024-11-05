<?php

declare(strict_types=1);

namespace App\Command\Interface;

interface Command
{
    public function execute(array $args): mixed;
}
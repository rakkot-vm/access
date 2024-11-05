<?php

declare(strict_types=1);

namespace App\Entity;

class User
{
    public int $id;
    public string $username;

    public function __construct(int $id, string $username)
    {
        $this->id = $id;
        $this->username = $username;
    }
}

<?php

declare(strict_types=1);


namespace App\Exception;

class UserNotFoundException extends \DomainException
{
    protected $message = 'USER_NOT_FOUND';
}

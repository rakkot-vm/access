<?php

declare(strict_types=1);


namespace App\Exception;

class FunctionNotFoundException extends \DomainException
{
    protected $message = 'FUNCTION_NOT_FOUND';
}

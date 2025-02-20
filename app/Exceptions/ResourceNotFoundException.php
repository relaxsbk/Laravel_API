<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ResourceNotFoundException extends Exception
{
    public function __construct(string $message = null, int $code = 404, Throwable $previous = null)
    {
        parent::__construct($message ?? getMessage('resource_not_found'), $code, $previous);
    }
}

<?php

namespace App\Exception;

use RuntimeException;

class BusinessLogicException extends RuntimeException
{
    public function __construct(string $description)
    {
        parent::__construct($description);
    }

}
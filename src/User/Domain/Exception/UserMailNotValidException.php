<?php

declare(strict_types=1);

namespace User\Domain\Exception;

use Exception;

class UserMailNotValidException extends Exception
{
    protected $message = 'User mail is not valid.';
}
<?php

declare(strict_types=1);

namespace User\Application\Command\RegisterUser;

use Exception;

class UserEmailAlreadyExistsException extends Exception
{
    protected $message = 'User email already exists.';
}
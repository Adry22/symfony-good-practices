<?php

namespace Universe\User\Exception;
use Exception;

class UserEmailAlreadyExistsException extends Exception
{
    protected $message = 'User email already exists.';
}
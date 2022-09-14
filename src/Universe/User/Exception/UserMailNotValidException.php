<?php

namespace Universe\User\Exception;

use Exception;

class UserMailNotValidException extends Exception
{
    protected $message = 'User mail is not valid.';
}
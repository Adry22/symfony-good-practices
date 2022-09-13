<?php
declare(strict_types=1);

namespace Universe\Planet\Exception;

use Exception;

class PlanetsNotFoundException extends Exception
{
    protected $message = 'Planets not found exception';
}
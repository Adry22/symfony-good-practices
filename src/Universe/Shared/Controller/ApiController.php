<?php
declare(strict_types=1);

namespace Universe\Shared\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class ApiController extends AbstractController
{
    public function __construct(
        ApiExceptionsHttpStatusCodeMapping $apiExceptionsHttpStatusCodeMapping
    ) {
        foreach ($this->exceptions() as $exceptionClass => $httpCode) {
            $apiExceptionsHttpStatusCodeMapping->register($exceptionClass, $httpCode);
        }
    }

    abstract protected function exceptions(): array;
}

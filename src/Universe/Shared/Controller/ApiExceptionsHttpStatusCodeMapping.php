<?php
declare(strict_types=1);

namespace Universe\Shared\Controller;

use InvalidArgumentException;

final class ApiExceptionsHttpStatusCodeMapping
{
    private array $exceptions = [];

    public function register(string $exceptionClass, int $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }

    public function statusCodeFor(string $exceptionClass): int
    {
        $statusCode = null;
        if (array_key_exists($exceptionClass, $this->exceptions)) {
            $statusCode = $this->exceptions[$exceptionClass];
        }

        if (null === $statusCode) {
            throw new InvalidArgumentException("There are no status code mapping for <$exceptionClass>");
        }

        return $statusCode;
    }
}
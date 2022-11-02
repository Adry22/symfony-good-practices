<?php
declare(strict_types=1);

namespace Universe\Shared\Controller;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;

final class ApiExceptionsHttpStatusCodeMapping
{
//    private array $exceptions = [];
//    private LoggerInterface $mainLogLogger;
//
//    public function __construct(LoggerInterface $mainLogLogger)
//    {
//        $this->mainLogLogger = $mainLogLogger;
//    }
//
//    public function register(string $exceptionClass, int $statusCode): void
//    {
//        $this->exceptions[$exceptionClass] = $statusCode;
//    }
//
//    public function statusCodeFor(string $exceptionClass): int
//    {
//        $statusCode = null;
//        if (array_key_exists($exceptionClass, $this->exceptions)) {
//            $statusCode = $this->exceptions[$exceptionClass];
//        }
//
//        if (null === $statusCode) {
//            $this->mainLogLogger->error("There are no status code mapping for <$exceptionClass>");
//            throw new InvalidArgumentException("There are no status code mapping for <$exceptionClass>");
//        }
//
//        $this->mainLogLogger->error("Exception: $exceptionClass - Status code: $statusCode");
//        return $statusCode;
//    }
}
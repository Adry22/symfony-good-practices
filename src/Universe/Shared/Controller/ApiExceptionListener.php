<?php
declare(strict_types=1);

namespace Universe\Shared\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ApiExceptionListener
{
    private ApiExceptionsHttpStatusCodeMapping $apiExceptionsHttpStatusCodeMapping;

    public function __construct(
        ApiExceptionsHttpStatusCodeMapping $apiExceptionsHttpStatusCodeMapping
    ) {
        $this->apiExceptionsHttpStatusCodeMapping = $apiExceptionsHttpStatusCodeMapping;
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $event->setResponse(
            new JsonResponse(
                [
                    'code'    => $this->apiExceptionsHttpStatusCodeMapping->statusCodeFor(get_class($exception)),
                    'message' => $exception->getMessage(),
                ],
                $this->apiExceptionsHttpStatusCodeMapping->statusCodeFor(get_class($exception))
            )
        );
    }
}
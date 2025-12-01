<?php
declare(strict_types=1);

namespace Shared\Infrastructure\Controller;

final class ApiExceptionListener
{
//    private ApiExceptionsHttpStatusCodeMapping $apiExceptionsHttpStatusCodeMapping;
//
//    public function __construct(
//        ApiExceptionsHttpStatusCodeMapping $apiExceptionsHttpStatusCodeMapping
//    ) {
//        $this->apiExceptionsHttpStatusCodeMapping = $apiExceptionsHttpStatusCodeMapping;
//    }
//
//    public function onException(ExceptionEvent $event): void
//    {
//        $exception = $event->getThrowable();
//
//        $event->setResponse(
//            new JsonResponse(
//                [
//                    'code'    => $this->apiExceptionsHttpStatusCodeMapping->statusCodeFor(get_class($exception)),
//                    'message' => $exception->getMessage(),
//                    'type' => (new ReflectionClass($exception))->getShortName(),
//                ],
//                $this->apiExceptionsHttpStatusCodeMapping->statusCodeFor(get_class($exception))
//            )
//        );
//    }
}
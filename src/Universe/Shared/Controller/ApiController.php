<?php
declare(strict_types=1);

namespace Universe\Shared\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class ApiController extends AbstractFOSRestController
{
    public function __construct(
        ApiExceptionsHttpStatusCodeMapping $apiExceptionsHttpStatusCodeMapping
    ) {
        foreach ($this->exceptions() as $exceptionClass => $httpCode) {
            $apiExceptionsHttpStatusCodeMapping->register($exceptionClass, $httpCode);
        }
    }

    protected function getParameterOrFail(Request $request, string $key)
    {
        $parameter = $request->get($key);

        if (null === $parameter) {
            throw new BadRequestHttpException('Invalid parameter ' . $key);
        }

        return $parameter;
    }

    abstract protected function exceptions(): array;
}

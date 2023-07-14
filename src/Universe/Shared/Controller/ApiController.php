<?php
declare(strict_types=1);

namespace Universe\Shared\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class ApiController extends AbstractFOSRestController
{
//    public function __construct(
//        ApiExceptionsHttpStatusCodeMapping $apiExceptionsHttpStatusCodeMapping
//    ) {
//        foreach ($this->exceptions() as $exceptionClass => $httpCode) {
//            $apiExceptionsHttpStatusCodeMapping->register($exceptionClass, $httpCode);
//        }
//    }
//
//
//    abstract protected function exceptions(): array;

    protected function getParameterOrFail(Request $request, string $key)
    {
        $parameter = $request->get($key);

        if (null === $parameter) {
            throw new BadRequestHttpException('Invalid parameter ' . $key);
        }

        return $parameter;
    }

    protected function getBodyParameter(Request $request, $key, $defaultValue = null)
    {
        $data = json_decode($request->getContent(), true);

        if (null === $data) {
            $data = $request->request->all();
        }

        if (false === array_key_exists($key, $data)) {
            return $defaultValue;
        }

        return $data[$key];
    }

    protected function getBodyParameterOrFail(Request $request, $key)
    {
        $parameter = $this->getBodyParameter($request, $key);

        if (null === $parameter) {
            throw new BadRequestHttpException('Invalid parameter ' . $key);
        }

        return $parameter;
    }

    public function binaryExcel(string $fileContent, string $filename): Response
    {
        return new Response(
            $fileContent,
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'inline; filename="' . $filename . '.xlsx"',
            ]
        );
    }
}

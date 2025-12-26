<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class ApiController extends AbstractFOSRestController
{
    protected function getQueryParameter(Request $request, string $key): ?string
    {
        return $request->get($key);
    }

    protected function getQueryParameterOrFail(Request $request, string $key)
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

    public function binaryWord(string $fileContent, string $filename): Response
    {
        return new Response(
            $fileContent,
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'inline; filename="' . $filename . '.docx"',
            ]
        );
    }
}

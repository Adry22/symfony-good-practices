<?php

declare(strict_types=1);

namespace User\Infrastructure\Controller;

use OpenApi\Attributes as OA;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Command\RegisterUser\RegisterUserCommand;
use User\Application\Command\RegisterUser\UserEmailAlreadyExistsException;

class RegisterUserController extends ApiController
{
    public function __construct(private readonly CommandBus $commandBus) {
    }

    #[Route('/register-user/{uuid}', defaults: ['_format' => 'json'], methods: ['POST'])]
    #[OA\Post(
        path: '/register-user/{uuid}',
        description: 'Register user',
        tags: ['user'],
        parameters: [
            new OA\Parameter(
                name: 'email',
                description: 'User email',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'password',
                description: 'User password',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success'
            ),
            new OA\Response(
                response: 400,
                description: 'Bad Request'
            )
        ]
    )]
    public function action(Request $request, string $uuid): Response
    {
        $email = $this->getBodyParameterOrFail($request, 'email');
        $password = $this->getBodyParameterOrFail($request, 'password');

        try {
            $command = new RegisterUserCommand(
                $uuid,
                $email,
                $password
            );
            $this->commandBus->handle($command);
        } catch (UserEmailAlreadyExistsException $e) {
            $message = [
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'User email already exists',
                'type' => 'UserEmailAlreadyExistsException',
            ];
            return $this->handleView($this->view($message, Response::HTTP_BAD_REQUEST));
        }

        return $this->handleView($this->view(null, Response::HTTP_OK));
    }
}
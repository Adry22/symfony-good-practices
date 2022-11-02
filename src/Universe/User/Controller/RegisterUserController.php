<?php

namespace Universe\User\Controller;

use Symfony\Component\HttpFoundation\Response;
use Universe\Shared\Bus\Command\CommandBus;
use Universe\Shared\Controller\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Universe\User\Command\RegisterUser\RegisterUserCommand;
use Universe\User\Exception\UserEmailAlreadyExistsException;
use Universe\User\Exception\UserMailNotValidException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class RegisterUserController extends ApiController
{
    private CommandBus $commandBus;

    public function __construct(
        CommandBus $commandBus,
    ) {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/register-user", methods={"GET"}, defaults={"_format"="json"})
     * @param Request $request
     * @return JsonResponse
     */
    public function action(Request $request, ): Response
    {
        $email = $this->getParameterOrFail($request, 'email');
        $password = $this->getParameterOrFail($request, 'password');

        $command = new RegisterUserCommand($email, $password);
        $this->commandBus->handle($command);

        return $this->handleView($this->view(null, Response::HTTP_OK));
    }

//    protected function exceptions(): array
//    {
//        return [
//            TransportExceptionInterface::class => Response::HTTP_NOT_FOUND,
//            UserMailNotValidException::class => Response::HTTP_BAD_REQUEST,
//            UserEmailAlreadyExistsException::class => Response::HTTP_BAD_REQUEST
//        ];
//    }
}
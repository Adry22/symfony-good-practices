<?php

declare(strict_types=1);

namespace User\Infrastructure\Controller;

use OpenApi\Annotations as OA;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Command\RegisterUser\RegisterUserCommand;
use User\Application\Command\RegisterUser\UserEmailAlreadyExistsException;
use User\Domain\Exception\UserMailNotValidException;

class RegisterUserController extends ApiController
{
    public function __construct(private CommandBus $commandBus) {
    }

    /**
     * @Route("/register-user/{uuid}", methods={"POST"}, defaults={"_format"="json"})
     *
     * @OA\Post(
     *   path="/register-user/{uuid}",
     *   description="Register user",
     *   tags={"user"},
     *   @OA\Parameter(
     *      in="query",
     *      name="email",
     *      description="User email",
     *      required=true,
     *      @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *      in="query",
     *      name="password",
     *      description="User password",
     *      required=true,
     *      @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *      response="200",
     *      description="Success",
     *    ),
     *    @OA\Response(
     *      response="400",
     *      description="Bad Request"
     *    )
     * )
     */
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
        } catch (UserMailNotValidException $e) {
            $message = [
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'User email not valid',
                'type' => 'UserMailNotValidException',
            ];
            return $this->handleView($this->view($message, Response::HTTP_BAD_REQUEST));
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

//    protected function exceptions(): array
//    {
//        return [
//            TransportExceptionInterface::class => Response::HTTP_NOT_FOUND,
//            UserMailNotValidException::class => Response::HTTP_BAD_REQUEST,
//            UserEmailAlreadyExistsException::class => Response::HTTP_BAD_REQUEST
//        ];
//    }
}
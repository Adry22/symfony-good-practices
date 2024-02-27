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
use OpenApi\Annotations as OA;

class RegisterUserController extends ApiController
{
    private CommandBus $commandBus;

    public function __construct(
        CommandBus $commandBus,
    ) {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/register-user", methods={"POST"}, defaults={"_format"="json"})
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Post(
     *   path="/register-user",
     *   description="Register user",
     *   tags={"user"},
     *   @OA\Parameter(
     *      in="query",
     *      name="email",
     *      description="User email",
     *      required=true,
     *      @OA\Schema(type="email")
     *   ),
     *   @OA\Parameter(
     *      in="query",
     *      name="password",
     *      description="User password",
     *      required=true,
     *      @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Success",
     *   ),
     *   @OA\Response(
     *     response="400",
     *     description="User email not valid | User email already exists"
     *   )
     * )
     */
    public function action(Request $request): Response
    {
        $email = $this->getBodyParameterOrFail($request, 'email');
        $password = $this->getBodyParameterOrFail($request, 'password');

        $street = $this->getBodyParameter($request, 'street');
        $number = $this->getBodyParameter($request, 'number');
        $city = $this->getBodyParameter($request, 'city');
        $country = $this->getBodyParameter($request, 'country');

        try {
            $command = new RegisterUserCommand(
                $email,
                $password,
                $street,
                $number,
                $city,
                $country
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
<?php

declare(strict_types=1);

namespace User\Infrastructure\Controller;

use OpenApi\Annotations as OA;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Command\UpdateProfileUser\UpdateProfileUserCommand;
use User\Domain\Entity\User\UserNotFoundException;

class UpdateProfileUserController extends ApiController
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    #[Route('/user/{uuid}/update-profile', methods: ['POST'], defaults: ['_format' => 'json'])]
    /**
     *
     * @OA\Post(
     *   path="/user/{uuid}/update-profile",
     *   description="Update profile user",
     *   tags={"user"},
     *   @OA\Parameter(
     *      in="query",
     *      name="street",
     *      description="User street",
     *      required=false,
     *      @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *      in="query",
     *      name="number",
     *      description="User number",
     *      required=false,
     *      @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *      in="query",
     *      name="city",
     *      description="User city",
     *      required=false,
     *      @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *      in="query",
     *      name="country",
     *      description="User country",
     *      required=false,
     *      @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Success",
     *   ),
     *   @OA\Response(
     *     response="400",
     *     description="User not found"
     *   )
     * )
     */
    public function action(Request $request, string $uuid): Response
    {
        $street = $this->getBodyParameter($request, 'street');
        $number = $this->getBodyParameter($request, 'number');
        $city = $this->getBodyParameter($request, 'city');
        $country = $this->getBodyParameter($request, 'country');
        $name = $this->getBodyParameter($request, 'name');

        try {
            $command = new UpdateProfileUserCommand($uuid, $street, $number, $city, $country, $name);
            $this->commandBus->handle($command);
        } catch (UserNotFoundException $e) {
            $message = [
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'User not found',
                'type' => 'UserNotFoundException',
            ];
            return $this->handleView($this->view($message, Response::HTTP_BAD_REQUEST));
        }

        return $this->handleView($this->view(null, Response::HTTP_OK));
    }
}
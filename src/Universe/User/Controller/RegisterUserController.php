<?php

namespace Universe\User\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Universe\Shared\Controller\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Universe\Shared\Controller\ApiExceptionsHttpStatusCodeMapping;
use Universe\Shared\Mailer\MailtrapEmailSender;
use Universe\User\Exception\UserEmailAlreadyExistsException;
use Universe\User\Exception\UserMailNotValidException;
use Universe\User\Repository\UserRepository;
use Universe\User\UseCase\RegisterUserUseCase;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class RegisterUserController extends ApiController
{
    private UserRepository $userRepository;
    private MailtrapEmailSender $emailSender;
    private UserPasswordHasherInterface $userPasswordHasher;
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(
        ApiExceptionsHttpStatusCodeMapping $apiExceptionsHttpStatusCodeMapping,
        UserRepository $userRepository,
        MailtrapEmailSender $emailSender,
        UserPasswordHasherInterface $userPasswordHasher
    )
    {
        parent::__construct($apiExceptionsHttpStatusCodeMapping);
        $this->userRepository = $userRepository;
        $this->emailSender = $emailSender;
        $this->userPasswordHasher = $userPasswordHasher;

        $this->registerUserUseCase = new RegisterUserUseCase(
            $this->userRepository,
            $this->emailSender,
            $this->userPasswordHasher
        );
    }

    /**
     * @Route("/register-user", methods={"GET"}, defaults={"_format"="json"})
     * @param Request $request
     * @return JsonResponse
     * @throws TransportExceptionInterface
     * @throws UserMailNotValidException
     * @throws NonUniqueResultException
     * @throws UserEmailAlreadyExistsException
     */
    public function action(Request $request): JsonResponse
    {
        $email = $this->getParameterOrFail($request, 'email');
        $password = $this->getParameterOrFail($request, 'password');

        $this->registerUserUseCase->handle($email, $password);
        return $this->json('OK');
    }

    protected function exceptions(): array
    {
        return [
            TransportExceptionInterface::class => Response::HTTP_NOT_FOUND,
            UserMailNotValidException::class => Response::HTTP_BAD_REQUEST,
            UserEmailAlreadyExistsException::class => Response::HTTP_BAD_REQUEST
        ];
    }
}
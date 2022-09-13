<?php
declare(strict_types=1);

namespace Universe\Planet\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Universe\Planet\Exception\PlanetsNotFoundException;
use Universe\Planet\Repository\PlanetRepository;
use Universe\Planet\UseCase\ListPlanetsUseCase;
use Universe\Shared\Controller\ApiController;
use Universe\Shared\Controller\ApiExceptionsHttpStatusCodeMapping;

final class ListPlanetsController extends ApiController
{
    private PlanetRepository $planetRepository;

    public function __construct(
        ApiExceptionsHttpStatusCodeMapping $apiExceptionsHttpStatusCodeMapping,
        PlanetRepository $planetRepository
    )
    {
        parent::__construct($apiExceptionsHttpStatusCodeMapping);
        $this->planetRepository = $planetRepository;
    }

    /**
     * @Route("/planets", methods={"GET"}, defaults={"_format"="json"})
     * @param Request $request
     * @return JsonResponse
     * @throws PlanetsNotFoundException
     */
    public function action(Request $request): JsonResponse
    {
        $name = $request->get('name');
        $planets = (new ListPlanetsUseCase($this->planetRepository))->handle($name);
        return $this->json($planets);
    }

    protected function exceptions(): array
    {
        return [
            PlanetsNotFoundException::class => Response::HTTP_NOT_FOUND
        ];
    }
}
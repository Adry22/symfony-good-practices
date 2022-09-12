<?php
declare(strict_types=1);

namespace Universe\Planet\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Universe\Planet\Repository\PlanetRepository;
use Universe\Planet\UseCase\ListPlanetsUseCase;

final class ListPlanetsController extends AbstractController
{
    private PlanetRepository $planetRepository;

    public function __construct(
        PlanetRepository $planetRepository
    ) {
        $this->planetRepository = $planetRepository;
    }

    /**
     * @Route("/planets", methods={"GET"}, defaults={"_format"="json"})
     */
    public function action(Request $request): JsonResponse
    {
        $planets = (new ListPlanetsUseCase($this->planetRepository))->handle();

        return $this->json($planets);
    }
}
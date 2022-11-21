<?php
declare(strict_types=1);

namespace Universe\Planet\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Universe\Planet\Query\ListPlanet\ListPlanetQuery;
use Universe\Shared\Bus\Query\QueryBus;
use Universe\Shared\Controller\ApiController;

final class ListPlanetsController extends ApiController
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("/planets", methods={"GET"}, defaults={"_format"="json"})
     * @param Request $request
     * @return JsonResponse
     */
    public function action(Request $request): Response
    {
        $name = $this->getParameterOrFail($request, 'name');
        $offset = $request->get('offset') ? (int) $request->get('offset') : null;
        $limit = $request->get('limit') ? (int) $request->get('limit') : null;

        $query = new ListPlanetQuery($name, $offset, $limit);
        $planets = $this->queryBus->handle($query);

        return $this->handleView($this->view($planets, Response::HTTP_OK));
    }
}
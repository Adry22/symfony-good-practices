<?php
declare(strict_types=1);

namespace Universe\Planet\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Universe\Planet\Exception\PlanetsNotFoundException;
use Universe\Planet\Query\ListPlanetQuery;
use Universe\Shared\Bus\Query\QueryBus;
use Universe\Shared\Controller\ApiController;
use Universe\Shared\Controller\ApiExceptionsHttpStatusCodeMapping;

final class ListPlanetsController extends ApiController
{
    private QueryBus $queryBus;

    public function __construct(
        ApiExceptionsHttpStatusCodeMapping $apiExceptionsHttpStatusCodeMapping,
        QueryBus $queryBus
    )
    {
        parent::__construct($apiExceptionsHttpStatusCodeMapping);
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

        $query = new ListPlanetQuery($name);
        $planets = $this->queryBus->handle($query);

        return $this->handleView($this->view($planets->results(), Response::HTTP_OK));
    }

    protected function exceptions(): array
    {
        return [
            PlanetsNotFoundException::class => Response::HTTP_NOT_FOUND
        ];
    }
}
<?php

declare(strict_types=1);

namespace Planet\Infrastructure\Controller;

use OpenApi\Annotations as OA;
use Planet\Application\Query\ListPlanet\ListPlanetQuery;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     *
     * @OA\Get(
     *   path="/planets",
     *   description="List planets",
     *   tags={"planet"},
     *   @OA\Parameter(
     *      in="query",
     *      name="name",
     *      description="Planet name to filter",
     *      required=true,
     *      @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *      in="query",
     *      name="offset",
     *      description="Offset to paginate results",
     *      @OA\Schema(type="int")
     *   ),
     *   @OA\Parameter(
     *      in="query",
     *      name="limit",
     *      description="Limit to paginate results",
     *      @OA\Schema(type="int")
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Success",
     *     @OA\JsonContent(
     *       allOf={
     *         @OA\Schema(
     *         @OA\Property(property="total", type="integer"),
     *         @OA\Property(property="offset", type="integer"),
     *         @OA\Property(property="limit", type="integer"),
     *         @OA\Property(
     *           property="results",
     *           type="array",
     *           @OA\Items(
     *             @OA\Property(property="name", type="string"),
     *                )
     *              )
     *            )
     *          }
     *       )
     *   )
     * )
     */
    public function action(Request $request): Response
    {
        $name = $this->getQueryParameter($request, 'name');
        $offset = $request->get('offset') ? (int) $request->get('offset') : null;
        $limit = $request->get('limit') ? (int) $request->get('limit') : null;

        $query = new ListPlanetQuery($name, $offset, $limit);
        $planets = $this->queryBus->handle($query);

        return $this->handleView($this->view($planets, Response::HTTP_OK));
    }
}
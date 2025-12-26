<?php

declare(strict_types=1);

namespace Planet\Infrastructure\Controller;

use Planet\Application\Query\ListPlanet\ListPlanetQuery;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

final class ListPlanetsController extends ApiController
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    #[Route('/planets', defaults: ['_format' => 'json'], methods: ['GET'])]
    #[OA\Get(
        path: '/planets',
        description: 'List planets',
        tags: ['planet'],
        parameters: [
            new OA\Parameter(
                name: 'name',
                description: 'Planet name to filter',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'offset',
                description: 'Offset to paginate results',
                in: 'query',
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'limit',
                description: 'Limit to paginate results',
                in: 'query',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'total', type: 'integer'),
                        new OA\Property(property: 'offset', type: 'integer'),
                        new OA\Property(property: 'limit', type: 'integer'),
                        new OA\Property(
                            property: 'results',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'name', type: 'string')
                                ],
                                type: 'object'
                            )
                        )
                    ]
                )
            )
        ]
    )]
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
<?php

declare(strict_types=1);

namespace Planet\Infrastructure\Controller;

use OpenApi\Attributes as OA;
use Planet\Application\Query\DownloadExcelPlanetList\DownloadExcelPlanetListQuery;
use Planet\Application\Query\DownloadExcelPlanetList\DownloadExcelPlanetListResult;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadExcelPlanetsListController extends ApiController
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    #[Route('/download-excel-planets-list', defaults: ['_format' => 'json'], methods: ['GET'])]
    #[OA\Get(
        path: '/download-excel-planets-list',
        description: 'Download excel planets list',
        tags: ['planet'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Binary file'
            )
        ]
    )]
    public function action(Request $request): Response
    {
        $query = new DownloadExcelPlanetListQuery();
        /** @var DownloadExcelPlanetListResult $result */
        $result = $this->queryBus->handle($query);

        return $this->binaryExcel($result->fileContent(), $result->filename());
    }
}
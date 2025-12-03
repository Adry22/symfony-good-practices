<?php

declare(strict_types=1);

namespace Planet\Infrastructure\Controller;

use OpenApi\Annotations as OA;
use Planet\Application\Query\DownloadWordPlanetList\DownloadWordPlanetListQuery;
use Planet\Application\Query\DownloadWordPlanetList\DownloadWordPlanetListResult;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadWordPlanetsListController extends ApiController
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    #[Route('/download-word-planets-list', methods: ['GET'], defaults: ['_format' => 'json'])]
    /**
     *
     * @OA\Get(
     *   path="/download-word-planets-list",
     *   description="Download word planets list",
     *   tags={"planet"},
     *   @OA\Response(
     *     response="200",
     *     description="Binary file",
     *   )
     * )
     */
    public function action(Request $request): Response
    {
        $query = new DownloadWordPlanetListQuery();
        /** @var DownloadWordPlanetListResult $result */
        $result = $this->queryBus->handle($query);

        return $this->binaryWord($result->fileContent(), $result->filename());
    }
}
<?php declare(strict_types=1);

namespace Universe\Planet\Controller;

use Universe\Planet\Query\DownloadWordPlanetList\DownloadWordPlanetListQuery;
use Universe\Planet\Query\DownloadWordPlanetList\DownloadWordPlanetListResult;
use Universe\Shared\Bus\Query\QueryBus;
use Universe\Shared\Controller\ApiController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DownloadWordPlanetsListController extends ApiController
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    /**
     *
     * @Route("/download-word-planets-list", methods={"GET"}, defaults={"_format"="json"})
     * @param Request $request
     *
     * @return Response
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
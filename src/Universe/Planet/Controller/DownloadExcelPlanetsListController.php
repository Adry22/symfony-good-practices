<?php
declare(strict_types=1);
namespace Universe\Planet\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Universe\Planet\Query\DownloadExcelPlanetList\DownloadExcelPlanetListQuery;
use Universe\Planet\Query\DownloadExcelPlanetList\DownloadExcelPlanetListResult;
use Universe\Shared\Bus\Query\QueryBus;
use Universe\Shared\Controller\ApiController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class DownloadExcelPlanetsListController extends ApiController
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     *
     * @Route("/download-excel-planets-list", methods={"GET"}, defaults={"_format"="json"})
     * @param Request $request
     *
     * @OA\Get(
     *   path="/download-excel-planets-list",
     *   description="Download excel planets list",
     *   tags={"planet"},
     *   @OA\Response(
     *     response="200",
     *     description="Binary file",
     *   )
     * )
     */
    public function action(Request $request)
    {
        $query = new DownloadExcelPlanetListQuery();
        /** @var DownloadExcelPlanetListResult $result */
        $result = $this->queryBus->handle($query);

        return new Response(
            $result->fileContent(),
            Response::HTTP_OK,
            [
                'content-type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'content-disposition' => 'inline; filename="' . $result->filename() . '.xlsx"',
            ]
        );
    }
}
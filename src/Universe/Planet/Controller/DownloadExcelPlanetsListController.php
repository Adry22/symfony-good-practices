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

class DownloadExcelPlanetsListController extends ApiController
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("/download-excel-planets-list", methods={"GET"}, defaults={"_format"="json"})
     * @param Request $request
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
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'inline; filename="' . $result->filename() . '.xlsx"',
            ]
        );
    }
}
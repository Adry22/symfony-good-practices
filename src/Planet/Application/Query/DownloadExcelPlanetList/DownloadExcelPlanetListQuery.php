<?php

declare(strict_types=1);

namespace Planet\Application\Query\DownloadExcelPlanetList;

use Shared\Infrastructure\Bus\Query\Query;

class DownloadExcelPlanetListQuery extends Query
{
    public function __construct(
    ) {
        parent::__construct([]);
    }
}
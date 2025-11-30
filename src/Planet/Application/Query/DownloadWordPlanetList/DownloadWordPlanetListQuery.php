<?php

declare(strict_types=1);

namespace Planet\Application\Query\DownloadWordPlanetList;

use Universe\Shared\Bus\Query\Query;

class DownloadWordPlanetListQuery extends Query
{
    public function __construct(
    ) {
        parent::__construct([]);
    }
}
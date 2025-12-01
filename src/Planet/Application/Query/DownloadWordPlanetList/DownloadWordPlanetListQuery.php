<?php

declare(strict_types=1);

namespace Planet\Application\Query\DownloadWordPlanetList;

use Shared\Infrastructure\Bus\Query\Query;

class DownloadWordPlanetListQuery extends Query
{
    public function __construct(
    ) {
        parent::__construct([]);
    }
}
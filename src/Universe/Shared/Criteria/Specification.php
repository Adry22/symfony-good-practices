<?php
declare(strict_types=1);

namespace Universe\Shared\Criteria;

use Universe\Shared\Repository\BaseRepository;

interface Specification
{
    public function satisfyingElementsFrom(BaseRepository $repository): array;
}

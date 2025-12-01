<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use Shared\Infrastructure\Repository\BaseRepository;

interface Specification
{
    public function satisfyingElementsFrom(BaseRepository $repository): array;
}

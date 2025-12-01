<?php

declare(strict_types=1);

namespace User\Domain\Repository;

use User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function getEntityClassName(): string;
}
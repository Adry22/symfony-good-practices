<?php
declare(strict_types=1);

namespace Universe\User\Repository;

use Universe\User\Entity\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function getEntityClassName(): string;
}
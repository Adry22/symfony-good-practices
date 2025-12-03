<?php

declare(strict_types=1);

namespace User\Domain\Repository;

use User\Domain\Entity\User\User;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Entity\User\UserNotFoundException;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function getEntityClassName(): string;

    public function save($object): void;

    public function findAll(): array;

    /**
     * @throws UserNotFoundException
     */
    public function findByIdOrFail(UserId $id): User;
}
<?php

namespace Universe\User\Repository;

use Universe\Shared\Repository\BaseRepository;
use Universe\User\Entity\User;

class UserRepository extends BaseRepository
{
    public function getEntityClassName(): string
    {
        return User::class;
    }
}
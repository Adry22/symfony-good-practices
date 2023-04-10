<?php

namespace Universe\User\Repository;

use Doctrine\ORM\QueryBuilder;
use Universe\Shared\Repository\BaseRepository;
use Universe\User\Entity\User;
use Doctrine\ORM\NonUniqueResultException;

class DoctrineUserRepository extends BaseRepository implements UserRepositoryInterface
{
    private const ROOT_ALIAS = 'users';

    /**
     * @throws NonUniqueResultException
     */
    public function findByEmail(string $email): ?User
    {
        $queryBuilder = $this->createQueryBuilder(self::ROOT_ALIAS);
        $queryBuilder = $this->applyEmail($queryBuilder, $email);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    private function applyEmail(QueryBuilder $queryBuilder, string $email): QueryBuilder
    {
        return $queryBuilder->andWhere(self::ROOT_ALIAS . '.email = :email')
            ->setParameter('email', $email);
    }

    public function getEntityClassName(): string
    {
        return User::class;
    }
}
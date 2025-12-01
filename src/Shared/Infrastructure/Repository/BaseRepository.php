<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Shared\Domain\Repository\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected EntityRepository $repository;

    public function __construct(protected EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository($this->getEntityClassName());
    }

    abstract public function getEntityClassName();

    public function save($object)
    {
        $this->em->persist($object);
    }

    public function flush()
    {
        $this->em->flush();
    }

    public function remove($object): void
    {
        $this->em->remove($object);
    }

    /**
     * @deprecated Use innerJoinOnce instead
     */
    protected function joinOnce(QueryBuilder $qb, string $relation, string $alias): QueryBuilder
    {
        if (false === $this->aliasJoinExists($qb, $alias)) {
            $qb->innerJoin($qb->getRootAlias() . '.' . $relation, $alias);
        }

        return $qb;
    }

    protected function innerJoinOnce(
        QueryBuilder $qb,
        string $join,
        string $alias,
        ?string $conditionType = null,
        ?string $condition = null,
        ?string $indexBy = null
    ): QueryBuilder {
        if (false === $this->aliasJoinExists($qb, $alias)) {
            $qb->innerJoin($join, $alias, $conditionType, $condition, $indexBy);
        }

        return $qb;
    }

    protected function leftJoinOnce(
        QueryBuilder $qb,
        string $join,
        string $alias,
        ?string $conditionType = null,
        ?string $condition = null,
        ?string $indexBy = null
    ): QueryBuilder {
        if (false === $this->aliasJoinExists($qb, $alias)) {
            $qb->leftJoin($join, $alias, $conditionType, $condition, $indexBy);
        }

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $alias
     * @return bool
     */
    protected function aliasJoinExists(QueryBuilder $qb, string $alias): bool
    {
        /* @var Join[] $joinDqlParts */
        $joinDqlParts = $qb->getDQLPart('join');
        $aliasAlreadyExists = false;

        foreach ($joinDqlParts as $joins) {
            foreach ($joins as $join) {
                if ($join->getAlias() === $alias) {
                    $aliasAlreadyExists = true;
                    break;
                }
            }
        }

        return $aliasAlreadyExists;
    }

    protected function createQueryBuilder(string $alias): QueryBuilder
    {
        return $this->repository->createQueryBuilder($alias);
    }
}
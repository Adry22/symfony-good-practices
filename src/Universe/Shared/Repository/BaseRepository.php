<?php
declare(strict_types=1);

namespace Universe\Shared\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

abstract class BaseRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata($this->getEntityClassName()));
    }

    abstract public function getEntityClassName();


    public function save($object)
    {
        $this->getEntityManager()->persist($object);
    }

    public function flush()
    {
        $this->getEntityManager()->flush();
    }

    public function remove($object): void
    {
        $this->getEntityManager()->remove($object);
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
}
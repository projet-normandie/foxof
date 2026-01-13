<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @phpstan-return Query<mixed, mixed>
     */
    public function findAllQuery(): Query
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.platform', 'p')
            ->addSelect('p')
            ->orderBy('g.name', 'ASC')
            ->getQuery();
    }

    /**
     * @return Game[]
     */
    public function findFinishedGames(): array
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.platform', 'p')
            ->addSelect('p')
            ->where('g.finishedTimes > 0')
            ->orderBy('g.finishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}

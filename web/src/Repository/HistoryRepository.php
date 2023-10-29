<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\History;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<History>
 *
 * @method History|null find($id, $lockMode = null, $lockVersion = null)
 * @method History|null findOneBy(array $criteria, array $orderBy = null)
 * @method History[]    findAll()
 * @method History[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    public function add(History $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(History $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllSortByDateTime(): array
    {
        return $this->findBy([], ['dateTime' => Criteria::DESC]);
    }

    public function findStats(): array
    {
        $cities = $this->createQueryBuilder('h')
            ->select("h.city")
            ->where("h.city != ''")
            ->groupBy('h.city')
            ->orderBy('COUNT(h.city)', Criteria::DESC)
            ->getQuery()
            ->getDQL();

        return $this->createQueryBuilder('history')
            ->select(<<<QUERY
                        MIN(history.temperature) minTemperature,
                        MAX(history.temperature) maxTemperature,
                        AVG(history.temperature) avgTemperature
                    QUERY
            )
            ->addSelect("FIRST($cities) mostFrequentCity")
            ->getQuery()
            ->getSingleResult();
    }
}

<?php

namespace App\Repository;

use App\Entity\TournamentType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TournamentType>
 *
 * @method TournamentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method TournamentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method TournamentType[]    findAll()
 * @method TournamentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TournamentType::class);
    }

    public function save(TournamentType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TournamentType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return TournamentType[] Returns an array of Tournament Type objects
    */
   public function findByTitle(string $title): array
   {
       return $this->createQueryBuilder('t')
           ->andWhere('t.title = :title')
           ->setParameter('title', $title)
           ->orderBy('t.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

}

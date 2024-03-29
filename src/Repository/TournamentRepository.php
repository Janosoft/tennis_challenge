<?php

namespace App\Repository;

use App\Entity\Tournament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tournament>
 *
 * @method Tournament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tournament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tournament[]    findAll()
 * @method Tournament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournament::class);
    }

    public function save(Tournament $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tournament $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Tournament[] Returns an array of Tournament objects
    */
   public function findByDate(string $date): array
   {
       return $this->createQueryBuilder('t')
           ->andWhere('t.date = :date')
           ->setParameter('date', $date)
           ->orderBy('t.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

   /**
    * @return Tournament[] Returns an array of Tournament objects
    */
   public function findByType(string $title): array
   {
       return $this->createQueryBuilder('t')
           ->innerJoin('t.tournamentType','tt')
           ->andWhere('tt.title = :title')
           ->setParameter('title', $title)
           ->orderBy('t.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }



}

<?php

namespace App\Repository;

use App\Entity\TrainerHasPokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrainerHasPokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainerHasPokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainerHasPokemon[]    findAll()
 * @method TrainerHasPokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainerHasPokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainerHasPokemon::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TrainerHasPokemon $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(TrainerHasPokemon $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return TrainerHasPokemon[] Returns an array of TrainerHasPokemon objects
     */
    public function getAllPokemonsByTrainer($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.trainer_id = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return TrainerHasPokemon[] Returns an array of TrainerHasPokemon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrainerHasPokemon
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

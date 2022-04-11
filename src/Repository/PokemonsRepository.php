<?php

namespace App\Repository;

use App\Entity\Pokemons;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pokemons|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pokemons|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pokemons[]    findAll()
 * @method Pokemons[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemons::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Pokemons $entity, bool $flush = true): void
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
    public function remove(Pokemons $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Count Returns amount of pokemons in DB
    //  */
    // public function count()
    // {
    //     $qb = $repository->createQueryBuilder('t');
    //     return $qb
    //         ->select('count(t.id)')
    //         ->getQuery()
    //         ->useQueryCache(true)
    //         ->useResultCache(true, 3600)
    //         ->getSingleScalarResult();
    // }

    // /**
    //  * @return Pokemons[] Returns an array of Pokemons objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pokemons
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

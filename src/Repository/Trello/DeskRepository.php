<?php

namespace App\Repository\Trello;

use App\Entity\Trello\Desk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Desk>
 *
 * @method Desk|null find($id, $lockMode = null, $lockVersion = null)
 * @method Desk|null findOneBy(array $criteria, array $orderBy = null)
 * @method Desk[]    findAll()
 * @method Desk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Desk::class);
    }

    public function add(Desk $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Desk $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Desk[] Returns an array of Desk objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Desk
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

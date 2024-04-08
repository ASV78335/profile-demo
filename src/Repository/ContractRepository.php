<?php

namespace App\Repository;

use App\Entity\Contract;
use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contract>
 *
 * @method Contract|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contract|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contract[]    findAll()
 * @method Contract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contract::class);
    }

    public function save($entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param string $value
     * @return array|null Returns an array of Contract objects
     */
    public function findByAddress(string $value): ?array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager
            ->createQuery(
            'SELECT c FROM App\Entity\Contract c WHERE c.subscriber in 
            (SELECT s FROM App\Entity\Subscriber s WHERE s.street LIKE :value)'
            )
            ->setParameter('value', '%' . $value . '%');

        return $query->getResult();
    }

    /**
     * @param Product $product
     * @return array|null Returns an array of Contract objects
     */
    public function findByProduct(Product $product): ?array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager
            ->createQuery(
            'SELECT c FROM App\Entity\Contract c WHERE c.product = :product'
            )
            ->setParameter('product', $product);

        return $query->getResult();
    }

    /**
     * @param DateTimeImmutable $startDate
     * @param DateTimeImmutable $finalDate
     * @return array|null Returns an array of Contract objects
     */
    public function findByPeriod(DateTimeImmutable $startDate, DateTimeImmutable $finalDate): ?array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager
            ->createQuery(
                'SELECT c FROM App\Entity\Contract c WHERE c.signedAt >= :startDate AND c.signedAt <= :finalDate'
            )
            ->setParameter('startDate', $startDate)
            ->setParameter('finalDate', $finalDate);

        return $query->getResult();
    }

    //    /**
    //     * @return Contract[] Returns an array of Contract objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Contract
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

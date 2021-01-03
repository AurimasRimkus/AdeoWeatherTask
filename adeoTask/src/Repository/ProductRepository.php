<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findByArrayValue($value) {
		$entities = self::findByStringInArrayField($this->getEntityManager(), Product::class, 'weather', $value);
		return $entities;
	}

	/**
	 * @param EntityManagerInterface $entityManager
	 * @param string                 $entity
	 * @param string                 $arrayField
	 * @param string                 $string
	 *
	 * @return array
	 */
	public static function findByStringInArrayField(
		EntityManagerInterface $entityManager,
		string $entity,
		string $arrayField,
		string $string
	): array {
		$serializedString = serialize($string);
		$columnName       = $entityManager->getClassMetadata($entity)->getColumnName($arrayField);
		$qb               = $entityManager->createQueryBuilder();

		return $qb->select('u')
			->from($entity, 'u')
			->where(
				$qb->expr()
					->like(
						"u.$columnName",
						$qb->expr()->literal("%$serializedString%")
					)
			)
			->getQuery()
			->getResult();
	}

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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

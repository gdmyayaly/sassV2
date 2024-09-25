<?php

namespace App\Repository;

use App\Entity\ClientSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClientSection>
 */
class ClientSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientSection::class);
    }

//    /**
//     * @return ClientSection[] Returns an array of ClientSection objects
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
//    /**
//     * @return ClientSection[] Returns an array of ClientSection objects
//     */
        public function findSectionsByClientAndSectionTypeName($clientId, $sectionTypeId)
        {
            return $this->createQueryBuilder('cs')
                ->join('cs.section', 's')
                ->join('s.sectionType', 'st')
                ->where('cs.client = :clientId')
                ->andWhere('st.id = :sectionTypeId')
                ->setParameter('clientId', $clientId)
                ->setParameter('sectionTypeId', $sectionTypeId . '%')
                ->getQuery()
                ->getResult();
        }
        public function findSectionsByClientAndIsDefault($clientId)
            {
                return $this->createQueryBuilder('cs')
                    ->join('cs.section', 's')
                    ->join('s.sectionType', 'st')
                    ->where('cs.client = :clientId')
                    ->andWhere('st.isCommon = :isDefault')
                    ->setParameter('clientId', $clientId)
                    ->setParameter('isDefault', false)
                    ->getQuery()
                    ->getResult();
            }
//    public function findOneBySomeField($value): ?ClientSection
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

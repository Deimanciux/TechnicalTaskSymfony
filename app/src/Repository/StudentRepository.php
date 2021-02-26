<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function findAllStudentsByProject(Project $project)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        return $queryBuilder->select('s')
            ->innerJoin('s.group', 'g')
            ->innerJoin('g.project', 'p')
            ->where('p.id = :id')
            ->setParameter('id', $project)
            ->getQuery()
            ->getResult();
    }
}

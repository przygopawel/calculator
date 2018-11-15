<?php

namespace App\Repository;

use App\Domain\Operations\OperationsRepositoryInterface;
use App\Entity\Operations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class OperationsRepository extends ServiceEntityRepository implements OperationsRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Operations::class);
    }

    public function getAll(): ?array
    {
        return $this->findAll();
    }

    public function get(int $id): Operations
    {
        /**
         * @var Operations $operation
         */
        $operation =  $this->find($id);

        return $operation;
    }

    public function save(Operations $operation): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($operation);
        $entityManager->flush();
    }
}

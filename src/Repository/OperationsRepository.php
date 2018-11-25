<?php

namespace App\Repository;

use App\Domain\Operations\Exceptions\OperationNotFoundException;
use App\Domain\Operations\OperationsRepositoryInterface;
use App\Entity\Operation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class OperationsRepository extends ServiceEntityRepository implements OperationsRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    public function getAll(int $page, int $limit): ?array
    {
        return $this->findBy(
            [],
            null,
            $limit,
            ($page - 1) * $limit
        );
    }

    public function getCount(): ?int
    {
        return $this->count([]);
    }

    public function get(int $id): Operation
    {
        /**
         * @var Operation $operation
         */
        $operation = $this->find($id);

        if (!$operation) {
            throw new OperationNotFoundException($id);
        }

        return $operation;

    }

    public function save(Operation $operation): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($operation);
        $entityManager->flush();
    }
}

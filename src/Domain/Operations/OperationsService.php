<?php
namespace App\Domain\Operations;

use App\Domain\Operations\Commands\CreateOperationsCommand;
use App\Entity\Operation as OperationsEntity;

class OperationsService implements OperationsServiceInterface
{

    private  $operationsRepository;

    public function __construct(OperationsRepositoryInterface $operationsRepository){
        $this->operationsRepository = $operationsRepository;
    }

    public function getAllOperations(int $page, int $perPage): ?array
    {
        return $this->operationsRepository->getAll($page, $perPage);
    }

    public function getCount(): ?int
    {
        return $this->operationsRepository->getCount();
    }

    public function createOperations(CreateOperationsCommand $createCommand): OperationsEntity
    {
        $operation = new OperationsEntity($createCommand->getType());
        $operation->setParams($createCommand->getParams());

        $this->operationsRepository->save($operation);

        return $operation;
    }

    public function getOperation(int $id): OperationsEntity
    {
        return $this->operationsRepository->get($id);
    }

}
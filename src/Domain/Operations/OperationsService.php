<?php
namespace App\Domain\Operations;

use App\Domain\Operations\Commands\CreateOperationsCommand;
use App\Entity\Operations as OperationsEntity;

class OperationsService implements OperationsServiceInterface
{

    private  $operationsRepository;

    public function __construct(OperationsRepositoryInterface $operationsRepository){
        $this->operationsRepository = $operationsRepository;
    }

    public function getAllOperations(): ?array
    {
        return $this->operationsRepository->getAll();
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
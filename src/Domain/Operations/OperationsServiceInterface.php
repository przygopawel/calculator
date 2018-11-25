<?php
namespace App\Domain\Operations;

use App\Domain\Operations\Commands\CreateOperationsCommand;
use App\Domain\Operations\Exceptions\OperationNotFoundException;
use App\Entity\Operation as OperationsEntity;

interface OperationsServiceInterface {
    public function getAllOperations(int $page,int $perPage): ?array;

    public function getCount(): ?int;

    /**
     * @param int $id
     * @throws OperationNotFoundException when operation not found in repository
     * @return OperationsEntity
     */
    public function getOperation(int $id): OperationsEntity;

    public function createOperations(CreateOperationsCommand $createCommand): OperationsEntity;
}
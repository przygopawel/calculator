<?php
namespace App\Domain\Operations;

use App\Domain\Operations\Commands\CreateOperationsCommand;
use App\Entity\Operations as OperationsEntity;

interface OperationsServiceInterface {
    public function getAllOperations(): ?array;
    public function getOperation(int $id): OperationsEntity;
    public function createOperations(CreateOperationsCommand $createCommand): OperationsEntity;
}
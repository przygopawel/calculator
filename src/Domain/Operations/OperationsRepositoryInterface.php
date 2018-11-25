<?php
namespace App\Domain\Operations;


use App\Domain\Operations\Exceptions\OperationNotFoundException;
use App\Entity\Operation;

interface OperationsRepositoryInterface {
    public function getAll(int $page, int $limit): ?array;

    public function getCount(): ?int;

    /**
     * @param int $id
     * @throws OperationNotFoundException - when operation does not exist
     * @return Operation
     */
    public function get(int $id): Operation;

    public function save(Operation $operation): void;
}
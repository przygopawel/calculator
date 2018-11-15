<?php
namespace App\Domain\Operations;


use App\Entity\Operations;

interface OperationsRepositoryInterface {
    public function getAll(): ?array;
    public function get(int $id): Operations;
    public function save(Operations $operation): void;
}
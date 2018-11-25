<?php

namespace App\Entity;

use App\Domain\Operations\Exceptions\InvalidOperationParamsException;
use App\Domain\Operations\OperationType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperationsRepository")
 */
class Operation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="json_array")
     */
    private $params;

    /**
     * @ORM\Column(type="decimal", precision=2)
     */
    private $result;


    public function __construct(OperationType $type)
    {
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params): self
    {
        $this->params = $params;
        $this->result = round($this->calculateResult($params), 2);
        return $this;
    }

    public function getResult(): ?float
    {
        return $this->result;
    }

    private function calculateResult(array $params): ?float
    {
        switch ($this->type) {
            case OperationType::ADD:
                return $this->calculateAdd($params);
            case OperationType::SUBTRACT:
                return $this->calculateSubtract($params);
            case OperationType::DIVIDE:
                return $this->calculateDivide($params);
            case OperationType::MULTIPLY:
                return $this->calculateMultiply($params);
        }

        return null;
    }

    private function calculateDivide(array $params): float
    {
        return array_reduce($params, function ($result, $value) {
            if ($result === null) {
                return $value;
            }

            if ($value === 0) {
                throw new InvalidOperationParamsException();
            }

            $result /= $value;
            return $result;
        }, null);
    }

    private function calculateMultiply(array $params): float
    {
        return array_reduce($params, function ($result, $value) {
            if ($result === null) {
                return $value;
            }

            $result *= $value;
            return $result;
        }, null);
    }

    private function calculateAdd(array $params): float
    {
        return array_reduce($params, function ($result, $value) {
            $result += $value;
            return $result;
        }, 0);
    }

    private function calculateSubtract(array $params): float
    {
        return array_reduce($params, function ($result, $value) {
            if ($result === null) {
                return $value;
            }

            $result -= $value;
            return $result;
        }, null);
    }
}

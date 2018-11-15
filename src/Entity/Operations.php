<?php

namespace App\Entity;

use App\Domain\Operations\OperationType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperationsRepository")
 */
class Operations
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
     * @ORM\Column(type="integer")
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
        $this->result = $this->calculateResult($params);
        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function calculateResult(array $params): ?int
    {
        return 100;
    }
}

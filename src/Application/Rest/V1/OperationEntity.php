<?php
namespace App\Application\Rest\V1;

use App\Domain\Operations\OperationType;

class OperationEntity {
    /**
     * @var OperationType $type
     */
   private $type;

    /**
     * @var array $params
     */
    private $params;

    /**
     * @return OperationType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}
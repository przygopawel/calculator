<?php
namespace App\Domain\Operations\Commands;

use App\Domain\Operations\OperationType;

class CreateOperationsCommand
{
    private $type;
    private $params;

    public function __construct(OperationType $type, array $params)
    {
        $this->type = $type;
        $this->params = $params;
    }

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
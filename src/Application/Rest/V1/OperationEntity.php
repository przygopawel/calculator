<?php
namespace App\Application\Rest\V1;

use Symfony\Component\Validator\Constraints as Assert;
use App\Application\Validator as AppAssert;

class OperationEntity {
    /**
     * @var string $type
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @AppAssert\OperationType
     */
   private $type;

    /**
     * @var array $params
     * @Assert\Type("array")
     * @Assert\Count(
     *      min = 1,
     *      max = 50,
     *      minMessage = "You must specify at least two params",
     *      maxMessage = "You cannot specify more than {{ limit }} params")
     * )
     * @AppAssert\ContainsNumber
     */
    private $params;

    /**
     * @return string
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

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
}
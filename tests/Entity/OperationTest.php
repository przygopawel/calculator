<?php
namespace App\Tests\Entity;

use App\Domain\Operations\Exceptions\InvalidOperationParamsException;
use App\Domain\Operations\OperationType;
use App\Entity\Operation;
use PHPUnit\Framework\TestCase;

class OperationTest extends TestCase
{
    /**
     * @dataProvider invalidParametersProvider
     */
    public function testShouldReturnInvalidParameterErrorWhenParametersAreInvalid(OperationType $type, array $params)
    {
        $this->expectException(InvalidOperationParamsException::class);

        $operation = new Operation($type);
        $operation->setParams($params);
    }

    public function invalidParametersProvider()
    {
        return [
            [
                OperationType::DIVIDE(),// type divide and
                [1, 0] // second parameters 0
            ],
            [
                OperationType::DIVIDE(),// type divide and
                [1, 3, 4, 0] // fourth parameters 0
            ]
        ];
    }

    /**
     * @dataProvider validParametersProvider
     */
    public function testShouldCountResultWhenParametersAreValid(OperationType $type, array $params, $result)
    {
        $operation = new Operation($type);
        $operation->setParams($params);

        $this->assertEquals($operation->getResult(), $result);
    }
    public function validParametersProvider()
    {
        return [
            [
                OperationType::DIVIDE(),
                [60, 2],
                30
            ],
            [
                OperationType::DIVIDE(),
                [1, 4],
                0.25
            ],
            [
                OperationType::MULTIPLY(),
                [1, 3, 4, 0],
                0
            ],
            [
                OperationType::MULTIPLY(),
                [7, 3],
                21
            ],
            [
                OperationType::ADD(),
                [7, 3],
                10
            ],
            [
                OperationType::ADD(),
                [0, 3],
                3
            ],
            [
                OperationType::SUBTRACT(),
                [74, 3],
                71
            ],
            [
            OperationType::SUBTRACT(),
                [0, 3],
                -3
            ]
        ];
    }

}
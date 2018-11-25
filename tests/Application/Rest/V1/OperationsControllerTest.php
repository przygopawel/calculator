<?php
namespace App\Tests\Application\Rest\V1;

use App\Application\Rest\V1\Exceptions\BadRequestException;
use App\Application\Rest\V1\Exceptions\NotFoundException;
use App\Application\Rest\V1\OperationEntity;
use App\Application\Rest\V1\OperationsController;
use App\Domain\Operations\Exceptions\InvalidOperationParamsException;
use App\Domain\Operations\Exceptions\OperationNotFoundException;
use App\Domain\Operations\OperationsServiceInterface;
use App\Domain\Operations\OperationType;
use App\Entity\Operation;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class OperationsControllerTest extends TestCase
{
    /**
     * @var OperationsController
     */
    private $operationController;

    /**
     * @var MockObject
     */
    private $operationServiceMock;
    private $requestMock;

    public function setUp()
    {
        $this->operationServiceMock = $this->createMock(OperationsServiceInterface::class);

        $this->operationController = new OperationsController(
            $this->operationServiceMock
        );
    }

    public function testShouldReturnBadRequestErrorWhenPageIsOutOfRange()
    {
        $request = new Request([
            'page' => 999
        ]);

        $this->operationServiceMock
            ->method('getCount')
            ->willReturn(1);

        $this->operationServiceMock
            ->method('getAllOperations')
            ->willReturn([
                new Operation(OperationType::DIVIDE())
            ]);

        $this->expectException(BadRequestException::class);

        $this->operationController->cgetAction($request);
    }

    public function testShouldReturnBadRequestErrorWhenInvalidParametersHaveBeenSend()
    {
        $entity = new OperationEntity();
        $validationErrors = new ConstraintViolationList([
            new ConstraintViolation('invalid parameter', '', [], '', '', '')
        ]);


        $this->expectException(BadRequestException::class);

        $this->operationController->postAction($entity, $validationErrors);
    }

    public function testShouldReturnBadRequestErrorWhenInvalidParametersHaveBeenThrowDuringCreate()
    {
        $entity = new OperationEntity();
        $entity->setType(OperationType::DIVIDE);
        $entity->setParams([3, 4]);
        $validationErrors = new ConstraintViolationList();

        $this->operationServiceMock
            ->method('createOperations')
            ->will($this->throwException(new InvalidOperationParamsException()));

        $this->expectException(BadRequestException::class);

        $this->operationController->postAction($entity, $validationErrors);
    }

    public function testShouldReturnNotFoundErrorWhenOperationDoesNotExist()
    {
        $operationId = 999;

        $this->operationServiceMock
            ->method('getOperation')
            ->will($this->throwException(new OperationNotFoundException($operationId)));

        $this->expectException(NotFoundException::class);

        $this->operationController->getAction($operationId);
    }

}
<?php
namespace App\Tests\Domain\Operations;

use App\Domain\Operations\Commands\CreateOperationsCommand;
use App\Domain\Operations\Exceptions\InvalidOperationParamsException;
use App\Domain\Operations\Exceptions\OperationNotFoundException;
use App\Domain\Operations\OperationsRepositoryInterface;
use App\Domain\Operations\OperationsService;
use App\Domain\Operations\OperationType;
use App\Entity\Operation;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class OperationsServiceTest extends TestCase
{
    /**
     * @var OperationsService
     */
    private $operationService;

    /**
     * @var MockObject
     */
    private $operationRepositoryMock;

    public function setUp()
    {
        $this->operationRepositoryMock = $this->createMock(OperationsRepositoryInterface::class);

        $this->operationService = new OperationsService(
            $this->operationRepositoryMock
        );
    }

    public function testShouldReturnNotFoundErrorWhenOperationDoesNotExist()
    {
        $operationId = 9999999;

        $this->operationRepositoryMock
            ->method('get')
            ->will($this->throwException(new OperationNotFoundException($operationId)));

        $this->expectException(OperationNotFoundException::class);

        $this->operationService->getOperation($operationId);
    }

    public function testShouldReturnOperationWhenOperationExists()
    {
        $operationId = 1;

        $this->operationRepositoryMock
            ->method('get')
            ->willReturn(new Operation(OperationType::ADD()));

        $result = $this->operationService->getOperation($operationId);

        $this->assertInstanceOf(Operation::class, $result);
    }

    public function testShouldReturnTotalCountOfItems()
    {

        $this->operationRepositoryMock
            ->method('getCount')
            ->willReturn(100);

        $result = $this->operationService->getCount();

        $this->assertEquals(100, $result);
    }

    public function testShouldReturnItemsCollection()
    {
        $page = 1;
        $perPage = 10;

        $this->operationRepositoryMock
            ->method('getAll')
            ->willReturn([
                new Operation(OperationType::ADD()),
                new Operation(OperationType::DIVIDE()),
            ]);

        $result = $this->operationService->getAllOperations($page, $perPage);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Operation::class, $result[0]);
    }

    public function testShouldReturnCreatedOperationWhenOperationHaveBeenSavedCorrectly()
    {
        $command = new CreateOperationsCommand(
            OperationType::MULTIPLY(),
            [1,2,3]
        );

        $this->operationRepositoryMock
            ->method('save')
            ->will($this->returnArgument(0));

        $result = $this->operationService->createOperations($command);

        $this->assertInstanceOf(Operation::class, $result);
    }

    public function testShouldNotSaveOperationWhenOperationReturnInvalidParamError()
    {
        $command = new CreateOperationsCommand(
            OperationType::DIVIDE(),
            [1,0,3]
        );

        $this->operationRepositoryMock
            ->expects($this->exactly(0))
            ->method('save');

        $this->expectException(InvalidOperationParamsException::class);

        $this->operationService->createOperations($command);
    }

}
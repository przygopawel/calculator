<?php
namespace App\Application\Rest\V1;

use App\Application\Rest\V1\Exceptions\BadRequestException;
use App\Application\Rest\V1\Exceptions\NotFoundException;
use App\Domain\Operations\Exceptions\InvalidOperationParamsException;
use App\Domain\Operations\Exceptions\OperationNotFoundException;
use App\Domain\Operations\OperationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Domain\Operations\Commands\CreateOperationsCommand;
use App\Domain\Operations\OperationsServiceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class OperationsController implements ClassResourceInterface
{

    /**
     * @var OperationsServiceInterface
     */
    private $operationsService;

    /**
     * @param OperationsServiceInterface $operationsService
     */
    public function __construct(OperationsServiceInterface $operationsService)
    {
        $this->operationsService = $operationsService;
    }

    public function cgetAction(
        Request $request
    )
    {
        $page = $request->query->getInt('page', 1);
        $perPage = $request->query->getInt('per_page', 25);

        $operations = $this->operationsService->getAllOperations($page, $perPage);
        $totalItems = $this->operationsService->getCount();

        $totalPages = \ceil($totalItems / $perPage);

        if ($page !== 1 && $totalPages < $page) {
            throw new BadRequestException('Invalid page provided');
        }

        return View::create([
            'operations' => $operations,
            'total_items' => $totalItems,
            'total_pages' => $totalPages,
            'page' => $page,
            'per_page' => $perPage
        ],
            Response::HTTP_OK);
    }

    /**
     * @ParamConverter("entity", converter="fos_rest.request_body")
     * @param OperationEntity $entity
     * @param ConstraintViolationListInterface $validationErrors
     * @return View
     */
    public function postAction(
        OperationEntity $entity,
        ConstraintViolationListInterface $validationErrors
    )
    {
        try {
            if (\count($validationErrors) > 0) {
                throw new BadRequestException(null, $validationErrors);
            }

            $operationType = new OperationType($entity->getType());

            $command = new CreateOperationsCommand(
                $operationType,
                $entity->getParams()
            );

            $operation = $this->operationsService->createOperations($command);

            return View::create($operation, Response::HTTP_CREATED);
        } catch (InvalidOperationParamsException $error) {
            throw new BadRequestException($error->getMessage());
        }
    }

    public function getAction($id)
    {
        try {
            $operation = $this->operationsService->getOperation($id);

            return View::create($operation, Response::HTTP_OK);
        } catch (OperationNotFoundException $error) {
            throw new NotFoundException($error->getMessage());
        }

    }
}
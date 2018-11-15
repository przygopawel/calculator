<?php
namespace App\Application\Rest\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Domain\Operations\Commands\CreateOperationsCommand;
use App\Domain\Operations\OperationsServiceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;


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

    public function cgetAction()
    {
        $operations = $this->operationsService->getAllOperations();

        return View::create([
            'operations' => $operations
        ],
            Response::HTTP_OK);
    }

    /**
     * @ParamConverter("operation", converter="fos_rest.request_body")
     * @param Request $request
     * @return View
     */
    public function postAction(
        OperationEntity $operation,
        ConstraintViolationListInterface $validationErrors
    )
    {
        if (\count($validationErrors) > 0) {
            return View::create($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $command = new CreateOperationsCommand(
            $operation->getType(),
            $operation->getParams()
        );

        $operation = $this->operationsService->createOperations($command);

        return View::create($operation, Response::HTTP_CREATED);
    }

    public function getAction($id)
    {
        $operation = $this->operationsService->getOperation($id);

        return View::create($operation, Response::HTTP_OK);
    }
}
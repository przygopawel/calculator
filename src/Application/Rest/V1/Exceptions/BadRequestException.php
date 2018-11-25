<?php
namespace App\Application\Rest\V1\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationList;

class BadRequestException extends HttpException implements RestExceptions {
    private const ERROR_STATUS_CODE = 400;
    private const TITLE = 'Validation Failed';

    /**
     * @var ConstraintViolationList
     */
    private $validationError;

    public function __construct($message = null, $validationError = null)
    {
        parent::__construct($this::ERROR_STATUS_CODE, $message);

        $this->validationError = $validationError;
    }

    /**
     * @return ConstraintViolationList| null
     */
    public function getValidationError()
    {
        return $this->validationError;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return self::TITLE;
    }
}

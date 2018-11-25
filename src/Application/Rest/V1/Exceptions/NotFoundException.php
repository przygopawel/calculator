<?php
namespace App\Application\Rest\V1\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotFoundException extends HttpException implements RestExceptions {
    private const ERROR_STATUS_CODE = 404;
    private const TITLE = 'Not Found';

    public function __construct($message = null)
    {
        parent::__construct($this::ERROR_STATUS_CODE, $message);
    }

    public function getTitle()
    {
        return self::TITLE;
    }
}

<?php
namespace App\Domain\Operations\Exceptions;

class InvalidOperationParamsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid operation parameters');
    }
}
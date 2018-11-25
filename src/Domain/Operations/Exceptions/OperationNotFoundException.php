<?php
namespace App\Domain\Operations\Exceptions;

class OperationNotFoundException extends \Exception
{
    public function __construct(int $id)
    {
        parent::__construct(sprintf('OperationTest.php with %d does not exist', $id));
    }
}
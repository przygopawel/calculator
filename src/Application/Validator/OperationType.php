<?php
namespace App\Application\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class OperationType extends Constraint
{
    public $message = 'OperationTest.php type must be one of action: add, subtract, multiply or divide. given: {{ value }}';
}
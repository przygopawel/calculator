<?php
namespace App\Application\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsNumber extends Constraint
{
    public $message = 'The array should contain only number. Other value type given: {{ value }}';
}
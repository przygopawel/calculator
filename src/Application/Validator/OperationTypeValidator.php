<?php
namespace App\Application\Validator;

use App\Domain\Operations\OperationType as OperationTypeValue;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class OperationTypeValidator extends ConstraintValidator
{
    public function validatedBy()
    {
        return \get_class($this) . 'Validator';
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof OperationType) {
            throw new UnexpectedTypeException($constraint, OperationType::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if(!OperationTypeValue::isValid($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
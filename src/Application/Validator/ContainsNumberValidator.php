<?php
namespace App\Application\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ContainsNumberValidator extends ConstraintValidator
{
    public function validatedBy()
    {
        return \get_class($this) . 'Validator';
    }

    public function validate($values, Constraint $constraint)
    {
        if (!$constraint instanceof ContainsNumber) {
            throw new UnexpectedTypeException($constraint, ContainsNumber::class);
        }

        if (null === $values || '' === $values || !is_array($values)) {
            return;
        }

        foreach ($values as $value) {
            if (!is_numeric($value)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $value)
                    ->addViolation();
                return;
            }
        }
    }
}
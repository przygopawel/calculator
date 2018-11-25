<?php
namespace App\Domain\Operations;

use MyCLabs\Enum\Enum;

class OperationType extends Enum
{
    const ADD = 'add';
    const SUBTRACT = 'subtract';
    const MULTIPLY = 'multiply';
    const DIVIDE = 'divide';
}
<?php
namespace App\Domain\Operations;
use MyCLabs\Enum\Enum;

class OperationType extends Enum
{
    private const ADD = 'add';
    private const SUBTRACT = 'subtract';
    private const MULTIPLY = 'multiply';
    private const DIVIDE = 'divide';
}
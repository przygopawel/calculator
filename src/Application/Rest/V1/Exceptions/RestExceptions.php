<?php
namespace App\Application\Rest\V1\Exceptions;

interface RestExceptions {
    public function getMessage();
    public function getTitle();
    public function getStatusCode();
}
<?php

namespace App\Infrastructure\Exception;

use Symfony\Component\HttpFoundation\Response;

class LockedResponseException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Provided data is already processing...', Response::HTTP_LOCKED);
    }
}

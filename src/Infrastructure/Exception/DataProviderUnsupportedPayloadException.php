<?php

namespace App\Infrastructure\Exception;

use Symfony\Component\HttpFoundation\Response;

class DataProviderUnsupportedPayloadException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Provided payload is not valid.', Response::HTTP_BAD_REQUEST);
    }
}

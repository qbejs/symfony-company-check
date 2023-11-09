<?php

namespace App\Infrastructure\Exception;

use Symfony\Component\HttpFoundation\Response;

class DataProviderEmptyResponseException extends \Exception
{
    public function __construct()
    {
        parent::__construct('No data for given payload.', Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Infrastructure\Exception;

use Symfony\Component\HttpFoundation\Response;

class NoDataProviderException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Provided data provider is not supported.', Response::HTTP_BAD_REQUEST);
    }
}

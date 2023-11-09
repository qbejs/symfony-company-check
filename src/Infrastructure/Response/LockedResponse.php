<?php

namespace App\Infrastructure\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LockedResponse extends JsonResponse
{
    public function __construct(string $content = null, int $status = Response::HTTP_CONFLICT, array $headers = [])
    {
        parent::__construct([
            'status' => 'error',
            'message' => 'Provided data is already processing...',
        ], $status, $headers);
    }
}

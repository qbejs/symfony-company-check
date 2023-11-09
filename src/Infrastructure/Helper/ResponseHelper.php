<?php

namespace App\Infrastructure\Helper;

use App\Infrastructure\Helper\Enum\SerializationFormat;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

class ResponseHelper
{
    public function __construct(
        private readonly NormalizerInterface $normalizer,
        /** @var Serializer $serializer */
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function normalizeAndReturnResponse(mixed $data, array $options, SerializationFormat|string $format = SerializationFormat::JSON): Response
    {
        if (is_string($format)) {
            $format = SerializationFormat::tryFrom($format);
            if (false === $format instanceof SerializationFormat) {
                $format = SerializationFormat::JSON;
            }
        }

        $normalization = $this->normalizer->normalize($data, null, $options);

        if (SerializationFormat::JSON === $format) {
            return new JsonResponse($normalization);
        }

        return new ($this->serializer->encode($normalization, 'xml'));
    }

    public function returnSingleErrorResponse(string $message, array $context = [], int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $baseUid = Uuid::fromString('d9e7a184-5d5b-11ea-a62a-3499710062d0');
        $uid = Uuid::v5($baseUid, $message);

        $array = [
            'errors' => [
                [
                    'message' => $message,
                    'code' => $uid->toRfc4122(),
                    'context' => $context,
                ],
            ],
        ];

        return new JsonResponse($array, $code);
    }

    public function returnMultipleErrorsResponse(array $errors, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $data = [
            'errors' => [],
        ];

        foreach ($errors as $error) {
            $baseUid = Uuid::fromString('d9e7a184-5d5b-11ea-a62a-3499710062d0');
            $uid = Uuid::v5($baseUid, $error['field'].$error['message']);

            $data['errors'][] =
                [
                    'message' => $error['message'],
                    'code' => $uid->toRfc4122(),
                    'context' => [
                        'field' => $error['field'],
                    ],
                ];
        }

        return new JsonResponse($data, $code);
    }
}

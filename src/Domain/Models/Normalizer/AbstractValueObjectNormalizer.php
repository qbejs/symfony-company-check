<?php

namespace App\Domain\Models\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

abstract class AbstractValueObjectNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): mixed
    {
        return $object->getValue();
    }
}

<?php

namespace App\Domain\Models\Normalizer;

use App\Domain\Models\Company;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CompanyNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        /* @var Company $object */
        return [
            'id' => $object->getId()->getValue(),
            'name' => $object->getName()->getValue(),
            'address' => $object->getAddress()->getValue(),
            'type' => $object->getType()->getValue(),
            'regon' => $object->getRegon()->getValue(),
            'nip' => $object->getNip()->getValue(),
            'createdAt' => $object->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $object->getUpdatedAt()->format('Y-m-d H:i:s'),
            'deletedAt' => $object->getDeletedAt()?->format('Y-m-d H:i:s'),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Company;
    }
}

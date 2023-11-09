<?php

namespace App\Infrastructure\DataProviders;

use App\Domain\Interface\DataProviderInterface;
use App\Domain\Models\DTO\CreateCompanyDTO;
use App\Domain\Models\ValueObject\Company\CompanyKrs;
use App\Domain\Models\ValueObject\Company\CompanyNip;
use App\Domain\Models\ValueObject\Company\CompanyRegon;
use App\Infrastructure\Exception\NoDataProviderException;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class DataProviderManager
{
    private iterable $dataProviders;
    private const DEFAULT_PROVIDER = 'gus';

    public function __construct(#[TaggedIterator('app.data_provider')] iterable $dataProviders)
    {
        $this->dataProviders = $dataProviders;
    }

    private function getDataProvider(): ?DataProviderInterface
    {
        foreach ($this->dataProviders as $dataProvider) {
            if ($dataProvider->isSupported(self::DEFAULT_PROVIDER)) {
                return $dataProvider;
            }
        }

        return null;
    }

    /** @return CreateCompanyDTO[]
     * @throws \Exception
     */
    public function checkCompany(string $type, string $payload): array
    {
        $dataProvider = $this->getDataProvider();
        $searchFor = null;

        if (!$dataProvider) {
            throw new NoDataProviderException();
        }

        switch ($type) {
            case 'regon':
                $searchFor = new CompanyRegon($payload);
                break;
            case 'krs':
                $searchFor = new CompanyKrs($payload);
                break;
            case 'nip':
                $searchFor = new CompanyNip($payload);
                break;
        }

        return $dataProvider->checkCompany($searchFor, $type);
    }
}

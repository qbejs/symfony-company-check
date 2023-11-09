<?php

namespace App\Infrastructure\DataProviders\Adapters;

use App\Domain\Interface\DataProviderInterface;
use App\Domain\Models\DTO\CreateCompanyDTO;
use App\Domain\Models\ValueObject\Company\CompanyKrs;
use App\Domain\Models\ValueObject\Company\CompanyNip;
use App\Domain\Models\ValueObject\Company\CompanyRegon;
use App\Infrastructure\Exception\DataProviderEmptyResponseException;
use App\Infrastructure\Exception\DataProviderUnsupportedPayloadException;
use GusApi\Exception\NotFoundException;
use GusApi\GusApi;
use GusApi\RegonConstantsInterface;
use GusApi\ReportTypes;

class GusProvider implements DataProviderInterface
{
    private GusApi $client;
    private string $sessionId;
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new GusApi($this->apiKey, new \GusApi\Adapter\Soap\SoapAdapter(
            RegonConstantsInterface::BASE_WSDL_URL,
            RegonConstantsInterface::BASE_WSDL_ADDRESS
        ));
        $this->sessionId = $this->client->login();
    }

    /**
     * @throws \Exception
     */
    public function checkCompany(CompanyRegon|CompanyNip|CompanyKrs $number, string $type = 'regon'): array
    {
        return $this->getData($number->getValue(), $type);
    }

    public function isSupported(string $type): bool
    {
        return 'gus' === $type;
    }

    /**
     * @throws NotFoundException
     */
    private function getData(string $lookingFor, string $type = 'regon'): array
    {
        $entries = [];
        $data = null;

        if ('regon' === $type) {
            $data = $this->client->getByRegon($this->client->login(), $lookingFor);
        }

        if ('nip' === $type) {
            $data = $this->client->getByNip($this->sessionId, $lookingFor);
        }

        if ('krs' === $type) {
            $data = $this->client->getByKrs($this->sessionId, $lookingFor);
        }

        if (null === $data) {
            throw new DataProviderUnsupportedPayloadException();
        }

        if (empty($data)) {
            throw new DataProviderEmptyResponseException();
        }

        foreach ($data as $gusReport) {
            $reportType = ReportTypes::REPORT_ACTIVITY_PHYSIC_PERSON;
            $fullReport = $this->client->getFullReport($this->client->login(), $gusReport, $reportType);

            $entries[] = new CreateCompanyDTO(
                name: $gusReport->getName(),
                street: $gusReport->getStreet(),
                city: $gusReport->getCity(),
                zipCode: $gusReport->getZipCode(),
                province: $gusReport->getProvince(),
                regon: (int) $gusReport->getRegon(),
                nip: (int) $fullReport->dane->fiz_nip,
                type: (string) $fullReport->dane->fiz_podstawowaFormaPrawna_Nazwa,
                foundingDate: (string) $fullReport->dane->fiz_dataWpisuDoREGON
            );
        }

        return $entries;
    }
}

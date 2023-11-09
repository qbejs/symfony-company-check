<?php

namespace App\Application\RegonCheck\CommandHandler;

use App\Application\RegonCheck\Command\CreateCompanyCommand;
use App\Domain\Factory\CompanyFactory;
use App\Domain\Interface\CompanyRepositoryInterface;
use App\Domain\Models\DTO\CreateCompanyDTO;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateCompanyCommandHandler
{
    public function __construct(private readonly CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(CreateCompanyCommand $command): void
    {
        $factory = new CompanyFactory();
        $dto = new CreateCompanyDTO(
            name: $command->name,
            street: $command->street,
            city: $command->city,
            zipCode: $command->zipCode,
            province: $command->province,
            regon: $command->regon,
            nip: $command->nip,
            type: $command->type,
            krs: $command->krs
        );
        $company = $factory->createFromDTO($dto);

        $this->companyRepository->save($company);
    }
}

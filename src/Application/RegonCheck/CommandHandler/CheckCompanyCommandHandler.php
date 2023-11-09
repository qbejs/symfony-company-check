<?php

namespace App\Application\RegonCheck\CommandHandler;

use App\Application\RegonCheck\Command\CheckCompanyCommand;
use App\Application\RegonCheck\Service\RegonCheckService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CheckCompanyCommandHandler
{
    public function __construct(private readonly RegonCheckService $checkService)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(CheckCompanyCommand $command)
    {
        $check = $this->checkService->checkCompany($command->type, $command->number);

        if (!$check) {
            throw new \Exception('Cannot verify company');
        }

        return true;
    }
}

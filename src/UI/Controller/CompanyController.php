<?php

namespace App\UI\Controller;

use App\Application\RegonCheck\Command\CheckCompanyCommand;
use App\Application\RegonCheck\Query\GetVerifiedCompaniesQuery;
use App\Application\RegonCheck\Query\GetVerifiedCompanyQuery;
use App\Application\RegonCheck\Service\RegonCheckService;
use App\Domain\Models\DTO\ValidateCompanyDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CompanyController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly SerializerInterface $serializer,
        private readonly RegonCheckService $service
    ) {
    }

    #[Route(path: '/api/regon', name: 'company.list', methods: ['GET'])]
    public function getCompanies(GetVerifiedCompaniesQuery $dto): JsonResponse
    {
        $query = new GetVerifiedCompaniesQuery($dto->page, $dto->limit);
        $companies = $this->messageBus->dispatch($query);

        return new JsonResponse($this->serializer->serialize($this->service->getResultFromMessage($companies), 'json', ['groups' => 'company']), Response::HTTP_OK, [], true);
    }

    #[Route(path: '/api/regon/item/{id}', name: 'company.item', methods: ['GET'])]
    public function getCompany(int $id): JsonResponse
    {
        $query = new GetVerifiedCompanyQuery($id);
        $company = $this->messageBus->dispatch($query);

        return new JsonResponse($this->serializer->serialize($this->service->getResultFromMessage($company), 'json'), Response::HTTP_OK, [], true);
    }

    #[Route(path: '/api/regon', name: 'company.check', methods: ['POST'])]
    public function checkCompany(ValidateCompanyDTO $dto): JsonResponse
    {
        $this->messageBus->dispatch(new CheckCompanyCommand($dto));

        return new JsonResponse(['message' => 'Company added to lookup queue...']);
    }
}

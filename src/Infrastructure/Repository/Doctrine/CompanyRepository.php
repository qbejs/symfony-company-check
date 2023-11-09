<?php

namespace App\Infrastructure\Repository\Doctrine;

use App\Domain\Interface\CompanyRepositoryInterface;
use App\Domain\Models\Company;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;

class CompanyRepository implements CompanyRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($id): ?Company
    {
        return $this->entityManager->getRepository(Company::class)->find($id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Company::class)->findAll();
    }

    public function save(Company $company): void
    {
        $this->entityManager->persist($company);
        $this->entityManager->flush();
    }

    public function delete(Company $company): void
    {
        $this->entityManager->remove($company);
        $this->entityManager->flush();
    }

    public function getVerifiedCompanies($page, $limit): Query
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->from(Company::class, 'c');
        $qb->select('c');

        return $qb->getQuery();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByTypeAndNumber($type, $number): ?Company
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->from(Company::class, 'c');
        $qb->select('c');

        switch ($type) {
            case 'nip':
                $qb->andWhere('c.nip.nip = :number');
                break;
            case 'regon':
                $qb->andWhere('c.regon.regon = :number');
                break;
            case 'krs':
                $qb->andWhere('c.krs.krs = :number');
                break;
            default:
                return null;
        }

        $qb->setParameter('number', $number);

        return $qb->getQuery()->getOneOrNullResult();
    }
}

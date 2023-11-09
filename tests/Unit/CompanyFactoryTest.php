<?php

namespace App\Tests\Unit;

use App\Domain\Factory\CompanyFactory;
use App\Domain\Models\Company;
use App\Domain\Models\DTO\CreateCompanyDTO;
use App\Domain\Models\ValueObject\Company\CompanyAddress;
use App\Domain\Models\ValueObject\Company\CompanyName;
use App\Domain\Models\ValueObject\Company\CompanyNip;
use App\Domain\Models\ValueObject\Company\CompanyRegon;
use App\Domain\Models\ValueObject\Company\CompanyType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

class CompanyFactoryTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        // Create a validator instance
        $this->validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }

    public function testCreateFromDTO()
    {
        // Arrange
        $dto = new CreateCompanyDTO(
            name: 'Shine Clinic Jakub Skowron',
            street: 'ul. Powstańców Warszawy',
            city: 'Skarżysko-Kamienna',
            zipCode: '26-110',
            province: 'ŚWIĘTOKRZYSKIE',
            regon: '260780605',
            nip: '6631777942',
            type: 'OSOBA FIZYCZNA PROWADZĄCA DZIAŁALNOŚĆ GOSPODARCZĄ'
        );

        $factory = new CompanyFactory();

        // Act
        $company = $factory->createFromDTO($dto);

        // Assert
        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals(new CompanyName('Shine Clinic Jakub Skowron'), $company->getName());
        $this->assertEquals(new CompanyRegon('260780605'), $company->getRegon());
        $this->assertEquals(new CompanyNip('6631777942'), $company->getNip());
        $this->assertEquals(new CompanyType('OSOBA FIZYCZNA PROWADZĄCA DZIAŁALNOŚĆ GOSPODARCZĄ'), $company->getType());

        // Assuming CompanyAddress takes the full address as one string in this case
        $expectedAddress = new CompanyAddress(
            'ul. Powstańców Warszawy',
            '',
            '26-110',
            'ŚWIĘTOKRZYSKIE',
            'Skarżysko-Kamienna'
        );
        $this->assertEquals($expectedAddress, $company->getAddress());
    }

    public function testInvalidRegonAndNip()
    {
        // Arrange
        $dto = new CreateCompanyDTO(
            name: 'Shine Clinic Jakub Skowron',
            street: 'ul. Powstańców Warszawy',
            city: 'Skarżysko-Kamienna',
            zipCode: '26-110',
            province: 'ŚWIĘTOKRZYSKIE',
            regon: '210783625',
            nip: '6635727642',
            type: 'OSOBA FIZYCZNA PROWADZĄCA DZIAŁALNOŚĆ GOSPODARCZĄ'
        );

        $factory = new CompanyFactory();

        // Act and Assert
        $this->expectException(ValidationFailedException::class);

        // Validate the DTO
        $violations = $this->validator->validate($dto);

        // If there are violations, throw an exception
        if (count($violations) > 0) {
            throw new ValidationFailedException($dto, $violations);
        }

        $company = $factory->createFromDTO($dto);
    }
}

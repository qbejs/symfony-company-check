<?php

namespace App\Tests\Unit\ValueObject;

use App\Domain\Models\ValueObject\Company\CompanyNip;
use PHPUnit\Framework\TestCase;

class CompanyNipTest extends TestCase
{
    public function testCanBeInstantiatedWithValidNip(): void
    {
        $validNip = '6631777942';
        $companyNip = new CompanyNip($validNip);

        $this->assertInstanceOf(CompanyNip::class, $companyNip);
        $this->assertEquals($validNip, $companyNip->getValue());
    }

    public function testCannotBeInstantiatedWithInvalidNip(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $invalidNip = '1234567890';
        new CompanyNip($invalidNip);
    }
}

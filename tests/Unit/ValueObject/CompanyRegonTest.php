<?php

namespace App\Tests\Unit\ValueObject;

use App\Domain\Models\ValueObject\Company\CompanyRegon;
use PHPUnit\Framework\TestCase;

class CompanyRegonTest extends TestCase
{
    public function testCanBeInstantiatedWithValidKrs(): void
    {
        $validKrs = '260780605';
        $companyKrs = new CompanyRegon($validKrs);

        $this->assertInstanceOf(CompanyRegon::class, $companyKrs);
        $this->assertEquals($validKrs, $companyKrs->getValue());
    }

    public function testCannotBeInstantiatedWithInvalidKrs(): void
    {
        $this->expectException(\Exception::class);

        $invalidKrs = 'invalid_krs';
        new CompanyRegon($invalidKrs);
    }
}

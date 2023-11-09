<?php

namespace App\Tests\Unit\ValueObject;

use App\Domain\Models\ValueObject\Company\CompanyFoundingDate;
use PHPUnit\Framework\TestCase;

class CompanyFoundingDateTest extends TestCase
{
    public function testCanBeInstantiatedWithDateTime(): void
    {
        $dateString = '2000-01-01';
        $dateTime = new \DateTime($dateString);
        $foundingDate = new CompanyFoundingDate($dateTime);

        $this->assertInstanceOf(CompanyFoundingDate::class, $foundingDate);
        $this->assertEquals($dateTime, $foundingDate->getValue());
    }

    public function testGetValueReturnsDateTimeInterface(): void
    {
        $dateTime = new \DateTime('2000-01-01');
        $foundingDate = new CompanyFoundingDate($dateTime);

        $this->assertInstanceOf(\DateTimeInterface::class, $foundingDate->getValue());
        $this->assertEquals($dateTime, $foundingDate->getValue());
    }

    public function testCorrectDateIsReturned(): void
    {
        $dateString = '2000-01-01';
        $dateTime = new \DateTime($dateString);
        $foundingDate = new CompanyFoundingDate($dateTime);

        $this->assertEquals($dateString, $foundingDate->getValue()->format('Y-m-d'));
    }
}
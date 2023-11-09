<?php

namespace App\Tests\Unit\ValueObject;

use App\Domain\Models\ValueObject\Company\CompanyAddress;
use PHPUnit\Framework\TestCase;

class CompanyAddressTest extends TestCase
{
    public function testCanBeCreatedFromValidData(): void
    {
        $street = 'Main St';
        $buildingNumber = '123';
        $zipCode = '12345';
        $province = 'Province';
        $city = 'City';

        $address = new CompanyAddress($street, $buildingNumber, $zipCode, $province, $city);

        $this->assertInstanceOf(CompanyAddress::class, $address);
        $this->assertEquals($street, $address->getStreet());
        $this->assertEquals($buildingNumber, $address->getBuildingNumber());
        $this->assertEquals($zipCode, $address->getZipCode());
        $this->assertEquals($province, $address->getProvince());
        $this->assertEquals($city, $address->getCity());
    }

    public function testToStringReturnsFormattedAddress(): void
    {
        $address = new CompanyAddress('Main St', '123', '12345', 'Province', 'City');
        $expectedString = 'Main St 123, 12345 City, Province';

        $this->assertEquals($expectedString, (string) $address);
    }

    public function testGetValueReturnsFormattedAddress(): void
    {
        $address = new CompanyAddress('Main St', '123', '12345', 'Province', 'City');
        $expectedString = 'Main St 123, 12345 City, Province';

        $this->assertEquals($expectedString, $address->getValue());
    }

    public function testEqualsReturnsTrueForSameValues(): void
    {
        $address1 = new CompanyAddress('Main St', '123', '12345', 'Province', 'City');
        $address2 = new CompanyAddress('Main St', '123', '12345', 'Province', 'City');

        $this->assertTrue($address1->equals($address2));
    }

    public function testEqualsReturnsFalseForDifferentValues(): void
    {
        $address1 = new CompanyAddress('Main St', '123', '12345', 'Province', 'City');
        $address2 = new CompanyAddress('Second St', '456', '67890', 'AnotherProvince', 'AnotherCity');

        $this->assertFalse($address1->equals($address2));
    }

    public function testBuildingNumberCanBeOptional(): void
    {
        $address = new CompanyAddress('Main St', null, '12345', 'Province', 'City');
        $expectedString = 'Main St , 12345 City, Province';

        $this->assertNull($address->getBuildingNumber());
        $this->assertEquals($expectedString, (string) $address);
    }
}

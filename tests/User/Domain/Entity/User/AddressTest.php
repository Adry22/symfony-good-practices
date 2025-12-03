<?php

declare(strict_types=1);

namespace User\Domain\Entity\User;

use Monolog\Test\TestCase;
use User\Domain\Entity\User\Address\Address;
use User\Domain\Entity\User\Address\AddressInvalidArgumentException;

class AddressTest extends TestCase
{
    /**
     * @test
     * @dataProvider validAddresses
     */
    public function should_create_address_when_everything_is_correct(
        string $street,
        string $number,
        string $city,
        string $country
    ): void {
        $address = new Address(
            $street,
            $number,
            $city,
            $country
        );

        $this->assertSame(sprintf('%s %s, %s, %s', $street, $number, $city, $country), $address->toString());
    }

    public function validAddresses(): array
    {
        return [
            ['Madrid' => 'Calle falsa', '123', 'Madrid', 'España'],
            ['Barcelona' => 'Avenida siempre viva', '456', 'Barcelona', 'España'],
            ['Sevilla' => 'Plaza mayor', '789', 'Sevilla', 'España'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidAddresses
     */
    public function should_throw_exception_when_address_is_invalid(
        string $street,
        string $number,
        string $city,
        string $country
    ): void {
        $this->expectException(AddressInvalidArgumentException::class);

        new Address(
            $street,
            $number,
            $city,
            $country
        );
    }

    public function invalidAddresses(): array
    {
        return [
            ['Madrid2' => 'Avenida siempre viva', '456', 'Madrid2', 'España'],
            ['Ciudad inventada' => 'Calle falsa', '123', 'Ciudad inventada', 'España'],
        ];
    }
}

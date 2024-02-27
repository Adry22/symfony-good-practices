<?php declare(strict_types=1);

namespace Universe\Shared\ValueObject\Address;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class Address
{
    /** @ORM\Column(type="string") */
    private ?string $street;

    /** @ORM\Column(type="string") */
    private ?string $number;

    /** @ORM\Column(type="string") */
    private ?string $city;

    /** @ORM\Column(type="string") */
    private ?string $country;

    public const VALID_CITIES = [
        'Madrid',
        'Barcelona',
        'Valencia',
        'Sevilla',
        'Zaragoza',
        'Málaga'
    ];

    /**
     * @throws AddressCityIsNotValidException
     */
    public function __construct(
        ?string $street = null,
        ?string $number = null,
        ?string $city = null,
        ?string $country = null
    ) {
        $this->checkIsValidCity($city);

        $this->street = $street;
        $this->number = $number;
        $this->city = $city;
        $this->country = $country;
    }

    /**
     * @throws AddressCityIsNotValidException
     */
    private function checkIsValidCity(?string $city = null): void {
        if (!in_array($city, self::VALID_CITIES)) {
            throw new AddressCityIsNotValidException();
        }
    }

    public function __toString(): string
    {
        return sprintf(
            '%s %s, %s, %s',
            $this->street,
            $this->number,
            $this->city,
            $this->country
        );
    }
}
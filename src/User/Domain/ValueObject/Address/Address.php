<?php declare(strict_types=1);

namespace User\Domain\ValueObject\Address;

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
     * @throws AddressInvalidArgumentException
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
     * @throws AddressInvalidArgumentException
     */
    private function checkIsValidCity(?string $city = null): void {
        if (!in_array($city, self::VALID_CITIES)) {
            throw new AddressInvalidArgumentException();
        }
    }

    public function toString(): string
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
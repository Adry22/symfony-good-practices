<?php

declare(strict_types=1);

namespace User\Domain\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\ValueObject\Email;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use User\Domain\Entity\User\Address\Address;
use User\Domain\Entity\User\Address\AddressInvalidArgumentException;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Event\UserAddressChanged;
use User\Domain\Event\UserNameChanged;
use User\Domain\Event\UserRegistered;

#[ORM\Entity()]
#[ORM\Table(name:"users")]
final class User extends AggregateRoot implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type:"user_id")]
    private UserId $id;

    #[ORM\Column(type: 'email', length: 254, unique: true)]
    private Email $email;

    #[ORM\Column(type:"string")]
    private string $password;

    #[ORM\Embedded(class: UserProfile::class)]
    private UserProfile $profile;

    private function __construct(UserId $id, Email $email, UserProfile $profile)
    {
        $this->id = $id;
        $this->email = $email;
        $this->profile = $profile;
    }

    public static function create(UserId $id, Email $email): self
    {
        $profile = UserProfile::empty();

        $user = new self($id, $email, $profile);
        $user->setEmail($email);

        $user->record(new UserRegistered(
            $id->toString(),
            $email->toString()
        ));

        return $user;
    }

    /**
     * @throws AddressInvalidArgumentException
     */
    public function updateProfile(
        ?string $street = null,
        ?string $number = null,
        ?string $city = null,
        ?string $country = null,
        ?string $name = null
    ): void
    {
        $oldName = $this->profile->name();
        $oldAddress = $this->profile->address();

        $newAddress = new Address($street, $number, $city, $country);

        $this->profile->update(
            $newAddress,
            $name
        );

        if ($name && $name !== $oldName) {
            $this->record(new UserNameChanged(
                $this->id->toString(),
                $name,
                $oldName
            ));
        }

        if ($oldAddress && false === $oldAddress->equals($newAddress)) {
            $this->record(new UserAddressChanged(
                $this->id->toString(),
                $newAddress->street(),
                $newAddress->number(),
                $newAddress->city(),
                $newAddress->country()
            ));
        }
    }

    public function email(): Email
    {
        return $this->email;
    }


    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email->toString();
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function profile(): UserProfile
    {
        return $this->profile;
    }
}
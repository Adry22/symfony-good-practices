<?php

declare(strict_types=1);

namespace User\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use User\Domain\Exception\UserMailNotValidException;
use User\Domain\ValueObject\Address\Address;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
final class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @Id()
     * @Column(type="integer")
     * @GeneratedValue()
     */
    private int $id;

    /**
     * @Column(type="string", nullable=false)
     */
    private string $email;

    /**
     * @Column(type="string", nullable=false)
     */
    private string $password;

    /**
     * @ORM\Embedded(class="User\Domain\ValueObject\Address\Address")
     */
    private ?Address $address = null;

    /**
     * @throws UserMailNotValidException
     */
    public static function create(string $email, Address $address): self {
        $user = new self();
        $user->setEmail($email);
        $user->address = $address;

        return $user;
    }

    public function email(): string
    {
        return $this->email;
    }

    /**
     * @throws UserMailNotValidException
     */
    public function setEmail(string $email): void
    {
        $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (false === $validEmail) {
            throw new UserMailNotValidException();
        }

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
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function address(): Address
    {
        return $this->address;
    }
}
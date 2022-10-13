<?php
declare(strict_types=1);

namespace Universe\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Universe\User\Exception\UserMailNotValidException;

/**
 * @ORM\Entity(repositoryClass="Universe\User\Repository\UserRepository")
 * @Table(name="users")
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
     * @throws UserMailNotValidException
     */
    public static function create(string $email): self {
        $user = new self();
        $user->setEmail($email);

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
}
<?php
declare(strict_types=1);

namespace Universe\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Universe\User\Exception\UserMailNotValidException;

/**
 * @ORM\Entity(repositoryClass="Universe\User\Repository\UserRepository")
 * @Table(name="users")
 */
final class User
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

    private function __construct() {}

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
}
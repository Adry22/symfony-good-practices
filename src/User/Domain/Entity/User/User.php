<?php

declare(strict_types=1);

namespace User\Domain\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use User\Domain\Entity\User\Address\Address;
use User\Domain\Entity\User\UserId\UserId;
use User\Domain\Exception\UserMailNotValidException;

// TODO: Divide entities in domain and infrastructure cause of ORM annotations
// TODO: User php attributes instead of annotations
/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
final class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @Id()
     * @Column(type="user_id")
     */
    private UserId $id;

    /**
     * @Column(type="string", nullable=false)
     */
    private string $email;

    /**
     * @Column(type="string", nullable=false)
     */
    private string $password;

    /**
     * @ORM\Embedded(class="User\Domain\Entity\User\UserProfile")
     */
    private UserProfile $profile;

    private function __construct(UserId $id, string $email, UserProfile $profile)
    {
        $this->id = $id;
        $this->email = $email;
        $this->profile = $profile;
    }

    /**
     * @throws UserMailNotValidException
     */
    public static function create(UserId $id, string $email): self {
        $profile = UserProfile::empty();

        $user = new self($id, $email, $profile);
        $user->setEmail($email);

        return $user;
    }

    public function updateProfile(Address $address, string $name): void
    {
        $this->profile->update($address, $name);
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

    public function id(): UserId
    {
        return $this->id;
    }

    public function profile(): UserProfile
    {
        return $this->profile;
    }
}
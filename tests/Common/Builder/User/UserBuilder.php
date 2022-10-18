<?php

namespace Tests\Common\Builder\User;

use Doctrine\ORM\EntityManagerInterface;
use Universe\User\Entity\User;
use Exception;

class UserBuilder
{
    private EntityManagerInterface $entityManager;
    private ?string $email;
    private ?string $password;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function reset(): self
    {
        $this->email = null;
        $this->password = null;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function build(): User
    {
        if (null === $this->email) {
            throw new Exception('Email is required');
        }

        if (null === $this->password) {
            throw new Exception('Password is required');
        }

        $user = User::create($this->email);
        $user->setPassword($this->password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function withEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function withPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
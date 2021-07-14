<?php
declare(strict_types=1);

namespace Blog\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Blog\Core\DateTime;

#[ApiResource]
class User
{
    private int $id;
    private string $email;
    private string $username;
    private string $password;
    private string $name;
    private string $surname;
    private DateTime $createdAt;
    private ?DateTime $updatedAt;

    public function __construct(
        string $email,
        string $username,
        string $password,
        string $name,
        string $surname,
    ) {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->createdAt = new DateTime();
        $this->updatedAt = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function updated(): static
    {
        $this->updatedAt = new DateTime();

        return $this;
    }
}

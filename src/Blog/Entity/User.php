<?php
declare(strict_types=1);

namespace Blog\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Blog\Core\DateTime;
use Blog\Core\Password;
use Blog\Core\Strings;

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
        $this->changePassword($password);
        $this->name = Strings::capitalize($name);
        $this->surname = Strings::capitalize($surname);
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

    public function changePassword(string $password): User
    {
        $this->password = Password::hash($password);

        return $this;
    }

    public function verifyPassword(string $password): bool
    {
        if (!Password::verify($password, $this->getPassword())) {
            return false;
        }

        return true;
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

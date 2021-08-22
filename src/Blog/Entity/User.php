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
    private ?string $password;
    private string $name;
    private string $surname;
    private ?int $remoteId;
    private DateTime $createdAt;
    private ?DateTime $updatedAt;
    private ?DateTime $syncAt;

    public function __construct(
        string $email,
        string $username,
        ?string $password,
        string $name,
        string $surname,
        ?int $remoteId,
        DateTime $createdAt,
        ?DateTime $updatedAt,
        ?DateTime $syncAt,
    ) {
        $this->email = $email;
        $this->username = $username;
        $this->changePassword($password);
        $this->name = Strings::capitalize($name);
        $this->surname = Strings::capitalize($surname);
        $this->remoteId = $remoteId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->syncAt = $syncAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function changeEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function changeUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function changePassword(?string $password): User
    {
        if ($password !== null) {
            $password = Password::hash($password);
        }

        $this->password = $password;

        return $this;
    }

    public function verifyPassword(string $password): bool
    {
        if ($this->password === null) {
            return false;
        }

        if (!Password::verify($password, $this->password)) {
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

    public function changeName(string $name, string $surname): User
    {
        $this->name = $name;
        $this->surname = $surname;

        return $this;
    }

    public function getRemoteId(): ?int
    {
        return $this->remoteId;
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

    public function getSyncAt(): ?DateTime
    {
        return $this->syncAt;
    }

    public function changeSyncAt(?DateTime $syncAt): User
    {
        $this->syncAt = $syncAt;

        return $this;
    }
}

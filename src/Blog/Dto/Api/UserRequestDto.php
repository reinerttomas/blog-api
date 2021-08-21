<?php
declare(strict_types=1);

namespace Blog\Dto\Api;

class UserRequestDto
{
    private string $email;
    private string $username;
    private string $password;
    private string $name;
    private string $surname;
    private ?int $remoteId;

    public function __construct(
        string $email,
        string $username,
        string $password,
        string $name,
        string $surname,
        ?int $remoteId,
    ) {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->remoteId = $remoteId;
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

    public function getRemoteId(): ?int
    {
        return $this->remoteId;
    }
}

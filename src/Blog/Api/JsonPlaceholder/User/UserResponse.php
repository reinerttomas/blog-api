<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\User;

use Blog\Api\JsonPlaceholder\User\Attribute\Address;
use Blog\Api\JsonPlaceholder\User\Attribute\Company;
use JetBrains\PhpStorm\Pure;
use ReinertTomas\JsonPlaceholderApi\User\UserResponse as UserResponseApi;

class UserResponse
{
    private int $id;
    private string $name;
    private string $username;
    private string $email;
    private Address $address;
    private string $phone;
    private string $website;
    private Company $company;

    #[Pure]
    public function __construct(UserResponseApi $response)
    {
        $this->id = $response->getId();
        $this->name = $response->getName();
        $this->username = $response->getUsername();
        $this->email = $response->getEmail();
        $this->address = new Address($response->getAddress());
        $this->phone = $response->getPhone();
        $this->website = $response->getWebsite();
        $this->company = new Company($response->getCompany());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }
}

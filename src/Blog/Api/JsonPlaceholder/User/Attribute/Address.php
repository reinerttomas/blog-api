<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\User\Attribute;

use JetBrains\PhpStorm\Pure;
use ReinertTomas\JsonPlaceholderApi\User\Attribute\Address as AddressApi;

class Address
{
    private string $street;
    private string $suite;
    private string $city;
    private string $zipcode;
    private Geolocation $geolocation;

    #[Pure]
    public function __construct(AddressApi $response)
    {
        $this->street = $response->getStreet();
        $this->suite = $response->getSuite();
        $this->city = $response->getCity();
        $this->zipcode = $response->getZipcode();
        $this->geolocation = new Geolocation($response->getGeolocation());
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getSuite(): string
    {
        return $this->suite;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    public function getGeolocation(): Geolocation
    {
        return $this->geolocation;
    }
}

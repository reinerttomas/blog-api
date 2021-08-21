<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\User\Attribute;

use JetBrains\PhpStorm\Pure;
use ReinertTomas\JsonPlaceholderApi\User\Attribute\Geolocation as GeolocationApi;

class Geolocation
{
    private float $latitude;
    private float $longitude;

    #[Pure]
    public function __construct(GeolocationApi $response)
    {
        $this->latitude = $response->getLatitude();
        $this->longitude = $response->getLongitude();
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}

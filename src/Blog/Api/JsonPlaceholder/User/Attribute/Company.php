<?php
declare(strict_types=1);

namespace Blog\Api\JsonPlaceholder\User\Attribute;

use JetBrains\PhpStorm\Pure;
use ReinertTomas\JsonPlaceholderApi\User\Attribute\Company as CompanyApi;

class Company
{
    private string $name;
    private string $catchPhrase;
    private string $bs;

    #[Pure]
    public function __construct(CompanyApi $response)
    {
        $this->name = $response->getName();
        $this->catchPhrase = $response->getCatchPhrase();
        $this->bs = $response->getBs();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCatchPhrase(): string
    {
        return $this->catchPhrase;
    }

    public function getBs(): string
    {
        return $this->bs;
    }
}

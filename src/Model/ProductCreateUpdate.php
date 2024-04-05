<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class ProductCreateUpdate
{
    #[NotBlank]
    private ?string $name = null;

    #[NotBlank]
    private ?string $fullName = null;

    #[NotBlank]
    #[Range(
        notInRangeMessage: 'Value is out of range',
        min: 1,
        max: 1000000
    )]
    private ?int $rateLimit = null;

    #[NotBlank]
    #[Range(
        notInRangeMessage: 'Value is out of range',
        min: 1,
        max: 1000000
    )]
    private ?int $price = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getRateLimit(): ?int
    {
        return $this->rateLimit;
    }

    public function setRateLimit(?int $rateLimit): self
    {
        $this->rateLimit = $rateLimit;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }
}

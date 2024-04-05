<?php

namespace App\Model;

class ProductItem
{
    private readonly string $uuid;

    private ?string $name = null;

    private ?string $fullName = null;

    private ?string $rateLimit = null;

    private ?string $price = null;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

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

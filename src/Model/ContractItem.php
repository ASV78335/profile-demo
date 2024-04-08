<?php

namespace App\Model;

use DateTimeImmutable;

class ContractItem
{
    private readonly string $uuid;

    private ?string $subscriberName = null;

    private ?string $productName = null;

    private ?DateTimeImmutable $signedAt = null;


    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getSubscriberName(): ?string
    {
        return $this->subscriberName;
    }

    public function setSubscriberName(?string $subscriberName): self
    {
        $this->subscriberName = $subscriberName;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getSignedAt(): ?DateTimeImmutable
    {
        return $this->signedAt;
    }

    public function setSignedAt(?DateTimeImmutable $signedAt): self
    {
        $this->signedAt = $signedAt;

        return $this;
    }
}

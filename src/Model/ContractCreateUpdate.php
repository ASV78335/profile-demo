<?php

namespace App\Model;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Uuid;

class ContractCreateUpdate
{
    #[NotBlank]
    #[Uuid]
    private ?string $subscriberUuid = null;

    #[NotBlank]
    #[Uuid]
    private ?string $productUuid = null;

    #[NotBlank]
    #[Range(
        notInRangeMessage: 'Value is out of range',
        min: 'now',
        max: '+5 years'
    )]
    private ?DateTimeImmutable $signedAt = null;


    public function getSubscriberUuid(): ?string
    {
        return $this->subscriberUuid;
    }

    public function setSubscriberUuid(?string $subscriberUuid): self
    {
        $this->subscriberUuid = $subscriberUuid;

        return $this;
    }

    public function getProductUuid(): ?string
    {
        return $this->productUuid;
    }

    public function setProductUuid(?string $productUuid): self
    {
        $this->productUuid = $productUuid;

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

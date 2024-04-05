<?php

namespace App\Entity;

use App\Model\ContractCreateUpdate;
use App\Model\ContractItem;
use App\Repository\ContractRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private readonly string $uuid;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscriber $subscriber = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column]
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

    public function getSubscriber(): ?Subscriber
    {
        return $this->subscriber;
    }

    public function setSubscriber(?Subscriber $subscriber): self
    {
        $this->subscriber = $subscriber;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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

    public function toResponseItem(): ContractItem
    {
        return (new ContractItem())
            ->setUuid($this->getUuid())
            ->setSubscriberName($this->getSubscriber()->getName())
            ->setProductName($this->getProduct()->getName())
            ->setSignedAt($this->getSignedAt())
            ;
    }

    public static function fromCreateRequest(ContractCreateUpdate $model, Product $product, Subscriber $subscriber): self
    {
        $contract = new self();
        $contract
            ->setUuid(Uuid::v4())
            ->setSubscriber($subscriber)
            ->setProduct($product)
            ->setSignedAt($model->getSignedAt())
        ;
        return $contract;
    }

    public static function fromUpdateRequest(Contract $contract, ContractCreateUpdate $model, Product $product, Subscriber $subscriber): self
    {
        $contract
            ->setSubscriber($subscriber)
            ->setProduct($product)
            ->setSignedAt($model->getSignedAt())
        ;
        return $contract;
    }
}

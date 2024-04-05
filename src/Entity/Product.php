<?php

namespace App\Entity;

use App\Model\ProductCreateUpdate;
use App\Model\ProductItem;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private readonly string $uuid;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $fullName = null;

    #[ORM\Column]
    private ?int $rateLimit = null;

    #[ORM\Column]
    private ?int $price = null;


    #[ORM\OneToMany(targetEntity: Contract::class, mappedBy: 'subscriber')]
    private Collection $contracts;


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

    public function toResponseItem(): ProductItem
    {
        return (new ProductItem())
            ->setUuid($this->getUuid())
            ->setName($this->getName())
            ->setFullName($this->getFullName())
            ->setRateLimit($this->getRateLimit())
            ->setPrice($this->getPrice())
        ;
    }

    public static function fromCreateRequest(ProductCreateUpdate $model): self
    {
        $product = new self();
        $product
            ->setUuid(Uuid::v4())
            ->setName($model->getName())
            ->setFullName($model->getFullName())
            ->setRateLimit($model->getRateLimit())
            ->setPrice($model->getPrice())
        ;
        return $product;
    }

    public static function fromUpdateRequest(Product $product, ProductCreateUpdate $model): self
    {
        $product
            ->setName($model->getName())
            ->setFullName($model->getFullName())
            ->setRateLimit($model->getRateLimit())
            ->setPrice($model->getPrice())
        ;
        return $product;
    }
}

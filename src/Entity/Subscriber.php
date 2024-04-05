<?php

namespace App\Entity;

use App\Model\SubscriberCreateUpdate;
use App\Model\SubscriberItem;
use App\Repository\SubscriberRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SubscriberRepository::class)]
class Subscriber
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
    private ?string $street = null;

    #[ORM\Column(length: 10)]
    private ?string $house = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $apartment = null;

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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getHouse(): ?string
    {
        return $this->house;
    }

    public function setHouse(?string $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function getApartment(): ?string
    {
        return $this->apartment;
    }

    public function setApartment(?string $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }

    public function toResponseItem(): SubscriberItem
    {
        return (new SubscriberItem())
            ->setUuid($this->getUuid())
            ->setName($this->getName())
            ->setStreet($this->getStreet())
            ->setHouse($this->getHouse())
            ->setApartment($this->getApartment())
            ;
    }

    public static function fromCreateRequest(SubscriberCreateUpdate $model): self
    {
        $subscriber = new self();
        $subscriber
            ->setUuid(Uuid::v4())
            ->setName($model->getName())
            ->setStreet($model->getStreet())
            ->setHouse($model->getHouse())
            ->setApartment($model->getApartment())
        ;
        return $subscriber;
    }

    public static function fromUpdateRequest(Subscriber $subscriber, SubscriberCreateUpdate $model): self
    {
        $subscriber
            ->setName($model->getName())
            ->setStreet($model->getStreet())
            ->setHouse($model->getHouse())
            ->setApartment($model->getApartment())
        ;
        return $subscriber;
    }
}

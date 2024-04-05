<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class SubscriberCreateUpdate
{
    #[NotBlank]
    private ?string $name = null;

    #[NotBlank]
    private ?string $street = null;

    #[NotBlank]
    private ?string $house = null;

    private ?string $apartment = null;

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

    public function getHouse(): ?int
    {
        return $this->house;
    }

    public function setHouse(?int $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function getApartment(): ?int
    {
        return $this->apartment;
    }

    public function setApartment(?int $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }
}

<?php

namespace App\Model;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\NotBlank;

class RequestDate
{
    #[NotBlank]
    private ?DateTimeImmutable $date = null;

    public function getDate(): ?DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(?DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }
}

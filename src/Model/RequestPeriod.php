<?php

namespace App\Model;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\NotBlank;

class RequestPeriod
{
    #[NotBlank]
    private ?DateTimeImmutable $startDate = null;
    private ?DateTimeImmutable $finalDate = null;

    public function getStartDate(): ?DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(?DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getFinalDate(): ?DateTimeImmutable
    {
        return $this->finalDate;
    }

    public function setFinalDate(?DateTimeImmutable $finalDate): self
    {
        $this->finalDate = $finalDate;

        return $this;
    }
}

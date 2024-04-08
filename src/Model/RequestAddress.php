<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\NotBlank;

class RequestAddress
{
    #[NotBlank]
    private ?string $option = null;

    public function getOption(): ?string
    {
        return $this->option;
    }

    public function setOption(?string $option): self
    {
        $this->option = $option;

        return $this;
    }
}

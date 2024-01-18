<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient extends User
{

    #[ORM\Column(length: 13)]
    private ?string $nss = null;

    public function getNss(): ?string
    {
        return $this->nss;
    }

    public function setNss(string $nss): static
    {
        $this->nss = $nss;

        return $this;
    }
}

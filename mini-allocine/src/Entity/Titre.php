<?php

namespace App\Entity;

use App\Repository\TitreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TitreRepository::class)]
class Titre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 260)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contenu = null;

    #[ORM\Column(length: 50)]
    private ?string $realisateur = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $anneeSortie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getRealisateur(): ?string
    {
        return $this->realisateur;
    }

    public function setRealisateur(string $realisateur): static
    {
        $this->realisateur = $realisateur;

        return $this;
    }

    public function getAnneeSortie(): ?int
    {
        return $this->anneeSortie;
    }

    public function setAnneeSortie(int $anneeSortie): static
    {
        $this->anneeSortie = $anneeSortie;

        return $this;
    }
}

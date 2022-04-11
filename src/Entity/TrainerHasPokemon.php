<?php

namespace App\Entity;

use App\Repository\TrainerHasPokemonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainerHasPokemonRepository::class)]
class TrainerHasPokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Pokemons::class, inversedBy: 'trainerHasPokemon')]
    #[ORM\JoinColumn(nullable: false)]
    private $pokemon;

    #[ORM\ManyToOne(targetEntity: Trainers::class, inversedBy: 'trainerHasPokemon')]
    private $Trainer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPokemon(): ?Pokemons
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemons $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getTrainer(): ?Trainers
    {
        return $this->Trainer;
    }

    public function setTrainer(?Trainers $Trainer): self
    {
        $this->Trainer = $Trainer;

        return $this;
    }
}

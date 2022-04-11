<?php

namespace App\Entity;

use App\Repository\TrainersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainersRepository::class)]
class Trainers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $gender;

    #[ORM\ManyToMany(targetEntity: Pokemons::class, inversedBy: 'trainerid')]
    private $hasPokemons;

    #[ORM\OneToMany(mappedBy: 'Trainer', targetEntity: TrainerHasPokemon::class)]
    private $trainerHasPokemon;

    public function __construct()
    {
        $this->hasPokemons = new ArrayCollection();
        $this->trainerHasPokemon = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection<int, Pokemons>
     */
    public function getHasPokemons(): Collection
    {
        return $this->hasPokemons;
    }

    public function addHasPokemon(Pokemons $hasPokemon): self
    {
        if (!$this->hasPokemons->contains($hasPokemon)) {
            $this->hasPokemons[] = $hasPokemon;
        }

        return $this;
    }

    public function removeHasPokemon(Pokemons $hasPokemon): self
    {
        $this->hasPokemons->removeElement($hasPokemon);

        return $this;
    }

    /**
     * @return Collection<int, TrainerHasPokemon>
     */
    public function getTrainerHasPokemon(): Collection
    {
        return $this->trainerHasPokemon;
    }

    public function addTrainerHasPokemon(TrainerHasPokemon $trainerHasPokemon): self
    {
        if (!$this->trainerHasPokemon->contains($trainerHasPokemon)) {
            $this->trainerHasPokemon[] = $trainerHasPokemon;
            $trainerHasPokemon->setTrainer($this);
        }

        return $this;
    }

    public function removeTrainerHasPokemon(TrainerHasPokemon $trainerHasPokemon): self
    {
        if ($this->trainerHasPokemon->removeElement($trainerHasPokemon)) {
            // set the owning side to null (unless already changed)
            if ($trainerHasPokemon->getTrainer() === $this) {
                $trainerHasPokemon->setTrainer(null);
            }
        }

        return $this;
    }
}

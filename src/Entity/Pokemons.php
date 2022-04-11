<?php

namespace App\Entity;

use App\Repository\PokemonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonsRepository::class)]
class Pokemons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $img;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $canEvolve;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $evolveid;

    #[ORM\ManyToMany(targetEntity: Trainers::class, mappedBy: 'hasPokemons')]
    private $trainerid;

    #[ORM\OneToMany(mappedBy: 'pokemon', targetEntity: QRCodes::class, orphanRemoval: true)]
    private $pokemon;

    #[ORM\Column(type: 'integer')]
    private $value;

    #[ORM\OneToMany(mappedBy: 'pokemon', targetEntity: TrainerHasPokemon::class)]
    private $trainerHasPokemon;

    public function __construct()
    {
        $this->trainerid = new ArrayCollection();
        $this->pokemon = new ArrayCollection();
        $this->trainerHasPokemon = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
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

    public function getCanEvolve(): ?int
    {
        return $this->canEvolve;
    }

    public function setCanEvolve(int $canEvolve): self
    {
        $this->canEvolve = $canEvolve;

        return $this;
    }

    public function getEvolveid(): ?int
    {
        return $this->evolveid;
    }

    public function setEvolveid(?int $evolveid): self
    {
        $this->evolveid = $evolveid;

        return $this;
    }

    /**
     * @return Collection<int, Trainers>
     */
    public function getTrainerid(): Collection
    {
        return $this->trainerid;
    }

    public function addTrainerid(Trainers $trainerid): self
    {
        if (!$this->trainerid->contains($trainerid)) {
            $this->trainerid[] = $trainerid;
            $trainerid->addHasPokemon($this);
        }

        return $this;
    }

    public function removeTrainerid(Trainers $trainerid): self
    {
        if ($this->trainerid->removeElement($trainerid)) {
            $trainerid->removeHasPokemon($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, QRCodes>
     */
    public function getPokemon(): Collection
    {
        return $this->pokemon;
    }

    public function addPokemon(QRCodes $pokemon): self
    {
        if (!$this->pokemon->contains($pokemon)) {
            $this->pokemon[] = $pokemon;
            $pokemon->setPokemon($this);
        }

        return $this;
    }

    public function removePokemon(QRCodes $pokemon): self
    {
        if ($this->pokemon->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getPokemon() === $this) {
                $pokemon->setPokemon(null);
            }
        }

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

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
            $trainerHasPokemon->setPokemon($this);
        }

        return $this;
    }

    public function removeTrainerHasPokemon(TrainerHasPokemon $trainerHasPokemon): self
    {
        if ($this->trainerHasPokemon->removeElement($trainerHasPokemon)) {
            // set the owning side to null (unless already changed)
            if ($trainerHasPokemon->getPokemon() === $this) {
                $trainerHasPokemon->setPokemon(null);
            }
        }

        return $this;
    }
}

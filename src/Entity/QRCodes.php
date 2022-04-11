<?php

namespace App\Entity;

use App\Repository\QRCodesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QRCodesRepository::class)]
class QRCodes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $qr;

    #[ORM\Column(type: 'boolean')]
    private $used;

    #[ORM\ManyToOne(targetEntity: pokemons::class, inversedBy: 'pokemon')]
    #[ORM\JoinColumn(nullable: false)]
    private $pokemon;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $chained;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQr(): ?string
    {
        return $this->qr;
    }

    public function setQr(string $qr): self
    {
        $this->qr = $qr;

        return $this;
    }

    public function getUsed(): ?bool
    {
        return $this->used;
    }

    public function setUsed(bool $used): self
    {
        $this->used = $used;

        return $this;
    }

    public function getPokemon(): ?pokemons
    {
        return $this->pokemon;
    }

    public function setPokemon(?pokemons $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getChained(): ?int
    {
        return $this->chained;
    }

    public function setChained(?int $chained): self
    {
        $this->chained = $chained;

        return $this;
    }
}

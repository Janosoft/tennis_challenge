<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $lucky = null;

    #[ORM\Column]
    private ?bool $favorslocals = null;

    #[ORM\ManyToOne(inversedBy: 'localgames')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $homeplayer = null;

    #[ORM\ManyToOne(inversedBy: 'awaygames')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $awayplayer = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stage $stage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLucky(): ?int
    {
        return $this->lucky;
    }

    public function setLucky(int $lucky): self
    {
        $this->lucky = $lucky;

        return $this;
    }

    public function isFavorslocals(): ?bool
    {
        return $this->favorslocals;
    }

    public function setFavorslocals(bool $favorslocals): self
    {
        $this->favorslocals = $favorslocals;

        return $this;
    }

    public function getHomeplayer(): ?Player
    {
        return $this->homeplayer;
    }

    public function setHomeplayer(?Player $homeplayer): self
    {
        $this->homeplayer = $homeplayer;

        return $this;
    }

    public function getAwayplayer(): ?Player
    {
        return $this->awayplayer;
    }

    public function setAwayplayer(?Player $awayplayer): self
    {
        $this->awayplayer = $awayplayer;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): self
    {
        $this->stage = $stage;

        return $this;
    }
}

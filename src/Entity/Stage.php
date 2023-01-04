<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StageRepository::class)]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $sequence = null;

    #[ORM\OneToMany(mappedBy: 'stage', targetEntity: Game::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $games;

    #[ORM\ManyToOne(inversedBy: 'stages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tournament $tournament = null;

    public function __construct(int $sequence, Tournament $tournament)
    {
        $this->setSequence($sequence);
        $this->setTournament($tournament);
        $tournament->addStage($this);
        $this->games = new ArrayCollection();
    }

    /**
     * Convierte y devuelve el objeto como un array asociativo [nombre_atributo] => [valor_atributo]
     *
     * @return array Devuelve un array que contiene todos los atributos del objeto
     */
    public function toArray(): array
    {
        $gamesarray = [];
        foreach ($this->getGames() as $game) {
            array_push($gamesarray, $game->toArray());
        }

        $array = [
            "id" => $this->getId(),
            "sequence" => $this->getSequence(),
            "games" => $gamesarray,
        ];

        return $array;
    }

    /**
     * Convierte y devuelve el objeto en un formato JSON {"[nombre_atributo]" : "[valor_atributo]"}
     *
     * @return string Devuelve un string que contiene todos los atributos del objeto en formato JSON
     */
    public function toJSON(): string
    {
        $array = $this->toArray();

        return json_encode($array);
    }

    /**
     * Calcula y devuelve los ganadores de los partidos correspondientes a una Etapa
     * 
     * @return array Devuelve un array con objetos Player correspondientes a los ganadores de la Etapa
     */
    public function playStage(): array
    {
        $winners = array();
        foreach ($this->getGames() as $game) {
            array_push($winners, $game->playGame());
        }

        return $winners;
    }

    /* GETTERS Y SETTERS*/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): self
    {
        if ($sequence < 0) $sequence = 0;
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setStage($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getStage() === $this) {
                $game->setStage(null);
            }
        }

        return $this;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): self
    {
        $this->tournament = $tournament;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\TournamentRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TournamentRepository::class)]
class Tournament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'tournament', targetEntity: Stage::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $stages;

    #[ORM\ManyToOne(inversedBy: 'tournaments', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?TournamentType $tournamentType = null;

    #[ORM\Column(length: 255)]
    private ?string $winner = null;

    private string $json = "";

    public function __construct(string $date = "", TournamentType $tournamentType = null)
    {
        $this->setDate(new DateTime($date));
        if (!is_null($tournamentType)) {
            $this->setTournamentType($tournamentType);
        }
        $this->stages = new ArrayCollection();
    }

    public function toArray(): array
    {
        $stagesarray = [];
        foreach ($this->getStages() as $stage) {
            array_push($stagesarray, $stage->toArray());
        }

        $array = [
            "id" => $this->getId(),
            "date" => $this->getDate(),
            "tournament_type" => $this->getTournamentType()->toArray(),
            "stages" => $stagesarray,
        ];

        return $array;
    }

    public function toJSON(): string
    {
        $array = $this->toArray();

        return json_encode($array);
    }

    public function validAmountOfPlayers(int $playersCount): bool
    {
        // la cantidad de jugadores debe ser potencia de 2
        return ceil(log($playersCount, 2)) == floor(log($playersCount, 2));
    }

    public function playTournament(array $players)
    {
        if (!$this->validAmountOfPlayers(count($players))) die("La cantidad de jugadores no es potencia de 2");
        shuffle($players);

        $iteration = 0;
        while (count($players) != 1) {
            // CREAR STAGE
            $iteration++;
            $stage = new Stage($iteration, $this);
            while (!empty($players)) {
                new Game(array_pop($players), array_pop($players), $stage);
            }
            $players = $stage->playStage()->toArray();
        }

        $ganador = array_pop($players);

        // GUARDAR GANADOR
        $this->setWinner($ganador->getName());
    }

    public function playJsonTournament()
    {
        $jsonArray= json_decode($this->getJson(),true);
        
        // CREAR TIPO DE TORNEO
        $tournament_type = new TournamentType($jsonArray['tournament_type']['title'],$jsonArray['tournament_type']['skills']);
        $this->setTournamentType($tournament_type);
        
        // ARMAR LISTA DE JUGADORES        
        $players = array();
        foreach ($jsonArray['players'] as $playerlist)
        {
           array_push($players, new Player($playerlist['name'], $playerlist['strength'], $playerlist['speed'], $playerlist['reaction']));
        }
        $this->playTournament($players);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Stage>
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages->add($stage);
            $stage->setTournament($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getTournament() === $this) {
                $stage->setTournament(null);
            }
        }

        return $this;
    }

    public function getTournamentType(): ?TournamentType
    {
        return $this->tournamentType;
    }

    public function setTournamentType(?TournamentType $tournamentType): self
    {
        $this->tournamentType = $tournamentType;
        $tournamentType->addTournament($this);

        return $this;
    }

    public function getWinner(): ?string
    {
        return $this->winner;
    }

    public function setWinner(string $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function getJson(): ?string
    {
        return $this->json;
    }

    public function setJson(string $json): self
    {
        $this->json = $json;

        return $this;
    }
}

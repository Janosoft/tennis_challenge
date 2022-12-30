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

    #[ORM\OneToMany(mappedBy: 'tournament', targetEntity: Stage::class, orphanRemoval: true)]
    private Collection $stages;

    #[ORM\ManyToOne(inversedBy: 'tournaments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TournamentType $tournamentType = null;

    public function __construct(string $date, TournamentType $tournamentType)
    {
        $this->setDate(new DateTime($date));
        $this->setTournamentType($tournamentType);
        $this->stages = new ArrayCollection();
    }

    public static function fromJSON(string $json): Tournament
    {
        //TODO Implementar
        $tournament_type = new TournamentType("masculino", ['Strength', 'speed', 'cosaloca']);
        $tournament = new Tournament("2010-01-28", $tournament_type);
        $tournament_type->addTournament($tournament);
        return $tournament;
    }

    public function toArray():array
    {
        $stagesarray = [];
        foreach ($this->getStages() as $stage)
        {
            array_push($stagesarray, $stage->toArray());
        }

        $array = [
            "id" => $this->getId(),
            "date" => $this->getDate(),
            "tournament_type" => $this->getTournamentType()->toArray(),
            "stages"=> $stagesarray,
        ];

        return $array;
    }

    public function toJSON(): string
    {
        $array= $this->toArray();
        
        return json_encode($array);
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

        return $this;
    }
}

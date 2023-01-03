<?php

namespace App\Entity;

use Faker;
use App\Repository\TournamentTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TournamentTypeRepository::class)]
class TournamentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'tournamentType', targetEntity: Tournament::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $tournaments;

    #[ORM\Column]
    private array $skills = [];

    public function __construct(string $title = "", array $skills = [])
    {
        $this->setTitle($title);
        $this->setSkills($skills);
        $this->tournaments = new ArrayCollection();
    }

    public static function fromJSON(string $json): TournamentType
    {
        $data = json_decode($json, true);
        $title = (isset($data['title']) ? $data['title'] : "");
        $skills = (isset($data['skills']) ? $data['skills'] : []);
        return new TournamentType($title, $skills);
    }

    public function toArray(): array
    {
        $array = [
            "id" => $this->getId(),
            "title" => $this->getTitle(),
            "skills" => $this->getSkills(),
        ];

        return $array;
    }

    public function toJSON(): string
    {
        $array = $this->toArray();

        return json_encode($array);
    }

    public function __toString(): string
    {
        return "({$this->getId()}) {$this->getTitle()} Skills: " . implode(', ', $this->getSkills());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        if (empty($title)) {
            // crea valor al azar
            $faker = Faker\Factory::create();
            $this->title = ucfirst($faker->word());
        } else {
            $this->title = ucfirst($title);
        }

        return $this;
    }

    /**
     * @return Collection<int, Tournament>
     */
    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    public function addTournament(Tournament $tournament): self
    {
        if (!$this->tournaments->contains($tournament)) {
            $this->tournaments->add($tournament);
            $tournament->setTournamentType($this);
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): self
    {
        if ($this->tournaments->removeElement($tournament)) {
            // set the owning side to null (unless already changed)
            if ($tournament->getTournamentType() === $this) {
                $tournament->setTournamentType(null);
            }
        }

        return $this;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }

    public function setSkills(array $skills): self
    {
        if (empty($skills)) {
            $this->skills = Player::getPosibleSkills();
        } else {
            // convierte a minúsculas todos los skills
            $skills = array_map('strtolower', $skills);
            // limpia skills inválidos
            $this->skills = array_filter($skills, fn ($skill) => in_array($skill, Player::getPosibleSkills()));
        }

        return $this;
    }
}

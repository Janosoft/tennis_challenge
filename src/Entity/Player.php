<?php

namespace App\Entity;

use Faker;
use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $strength = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $speed = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $reaction = null;

    #[ORM\OneToMany(mappedBy: 'homeplayer', targetEntity: Game::class, orphanRemoval: true)]
    private Collection $localgames;

    #[ORM\OneToMany(mappedBy: 'awayplayer', targetEntity: Game::class, orphanRemoval: true)]
    private Collection $awaygames;

    public function __construct(string $name, int $strength, int $speed, int $reaction)
    {
        $this->setName($name);
        $this->setStrength($strength);
        $this->setSpeed($speed);
        $this->setReaction($reaction);
        $this->localgames = new ArrayCollection();
        $this->awaygames = new ArrayCollection();
    }

    public function __toString(): string
    {
        return "({$this->getId()}) {$this->getName()} ST:{$this->getStrength()} SP:{$this->getSpeed()} RE:{$this->getReaction()}";
    }

    /**
     * Crea un objeto Player desde un JSON que contiene sus atributos
     *
     * JSON DE EJEMPLO
     * {"name": "jano","strength": 80,"speed": 50,"reaction": 456}
     * 
     * @return Player Devuelve un objeto Player inicializado
     */
    public static function fromJSON(string $json): Player
    {
        $faker = Faker\Factory::create();
        $data = json_decode($json, true);
        $name = (isset($data['name']) ? $data['name'] : "");
        $strength = (isset($data['strength']) ? $data['strength'] : $faker->numberBetween(0, 100));
        $speed = (isset($data['speed']) ? $data['speed'] : $faker->numberBetween(0, 100));
        $reaction = (isset($data['reaction']) ? $data['reaction'] : $faker->numberBetween(0, 100));

        return new Player($name, $strength, $speed, $reaction);
    }

    /**
     * Convierte y devuelve el objeto como un array asociativo [nombre_atributo] => [valor_atributo]
     *
     * @return array Un array que contiene todos los atributos del objeto
     */
    public function toArray(): array
    {
        $array = [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "strength" => $this->getStrength(),
            "speed" => $this->getSpeed(),
            "reaction" => $this->getReaction(),
        ];

        return $array;
    }

    /**
     * Convierte y devuelve el objeto en un formato JSON {"[nombre_atributo]" : "[valor_atributo]"}
     *
     * @return string Un string que contiene todos los atributos del objeto en formato JSON
     */
    public function toJSON(): string
    {
        $array = $this->toArray();

        return json_encode($array);
    }

    /**
     * Devuelve las posibles habilidades de un jugador que podrán ser utilizadas para competir
     *
     * @return array Devuelve un array de strings con el nombre de habilidades disponibles
     */
    public static function getPosibleSkills(): array
    {
        return ['strength', 'speed', 'reaction'];
    }

    /* GETTERS Y SETTERS*/

    public function getSkill(string $skill): int
    {
        if (in_array($skill, Player::getPosibleSkills())) return (int) $this->$skill;
        else return 0;
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
        if (empty($name)) {
            // crea valor al azar
            $faker = Faker\Factory::create();
            $this->name = $faker->name();
        } else {
            $this->name = $name;
        }

        return $this;
    }

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): self
    {
        // controla los límites posibles 0-100
        if ($strength < 0) {
            $this->strength = 0;
        } elseif ($strength > 100) {
            $this->strength = 100;
        } else {
            $this->strength = $strength;
        }

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): self
    {
        // controla los límites posibles 0-100            
        if ($speed < 0) {
            $this->speed = 0;
        } elseif ($speed > 100) {
            $this->speed = 100;
        } else {
            $this->speed = $speed;
        }

        return $this;
    }

    public function getReaction(): ?int
    {
        return $this->reaction;
    }

    public function setReaction(int $reaction): self
    {
        // controla los límites posibles 0-100
        if ($reaction < 0) {
            $this->reaction = 0;
        } elseif ($reaction > 100) {
            $this->reaction = 100;
        } else {
            $this->reaction = $reaction;
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getLocalgames(): Collection
    {
        return $this->localgames;
    }

    public function addLocalgame(Game $localgame): self
    {
        if (!$this->localgames->contains($localgame)) {
            $this->localgames->add($localgame);
            $localgame->setHomeplayer($this);
        }

        return $this;
    }

    public function removeLocalgame(Game $localgame): self
    {
        if ($this->localgames->removeElement($localgame)) {
            // set the owning side to null (unless already changed)
            if ($localgame->getHomeplayer() === $this) {
                $localgame->setHomeplayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getAwaygames(): Collection
    {
        return $this->awaygames;
    }

    public function addAwaygame(Game $awaygame): self
    {
        if (!$this->awaygames->contains($awaygame)) {
            $this->awaygames->add($awaygame);
            $awaygame->setAwayplayer($this);
        }

        return $this;
    }

    public function removeAwaygame(Game $awaygame): self
    {
        if ($this->awaygames->removeElement($awaygame)) {
            // set the owning side to null (unless already changed)
            if ($awaygame->getAwayplayer() === $this) {
                $awaygame->setAwayplayer(null);
            }
        }

        return $this;
    }
}

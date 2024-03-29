<?php

namespace App\Entity;

use Faker;
use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

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

    #[ORM\ManyToOne(inversedBy: 'localgames', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $homeplayer = null;

    #[ORM\ManyToOne(inversedBy: 'awaygames', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $awayplayer = null;

    #[ORM\ManyToOne(inversedBy: 'games', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stage $stage = null;

    public function __construct(Player $homeplayer, Player $awayplayer, Stage $stage)
    {
        if ($homeplayer === $awayplayer) throw new InvalidArgumentException('Player vs Same Player');
        $faker = Faker\Factory::create();
        $this->setHomeplayer($homeplayer);
        $this->setAwayplayer($awayplayer);
        $this->setStage($stage);
        $this->setLucky($faker->numberBetween(0, 10));
        $this->setFavorslocals($faker->boolean());

        $awayplayer->addAwaygame($this);
        $homeplayer->addLocalgame($this);
        $stage->addGame($this);
    }

    /**
     * Convierte y devuelve el objeto como un array asociativo [nombre_atributo] => [valor_atributo]
     *
     * @return array Devuelve un array que contiene todos los atributos del objeto
     */
    public function toArray(): array
    {
        $array = [
            "id" => $this->getId(),
            "lucky" => $this->getLucky(),
            "favorslocals" => ($this->isFavorslocals() ? "true" : "false"),
            "homeplayer" => $this->getHomeplayer()->toArray(),
            "awayplayer" => $this->getAwayplayer()->toArray(),
            "winner" => $this->playGame()->toArray(),
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
     * Calcula y devuelve el ganador de un partido según sus puntos de habilidad, la suerte, y si se favorece al jugador local
     * 
     * @return Player Devuelve un objeto Player correspondiente al ganador del Game
     */
    public function playGame(): Player
    {
        $skillPointsHomePlayer = $this->getPlayerSkillPoints($this->getHomeplayer());
        $skillPointsAwayPlayer = $this->getPlayerSkillPoints($this->getAwayplayer());

        if ($this->isFavorslocals()) $skillPointsHomePlayer += $this->getLucky();
        else $skillPointsAwayPlayer += $this->getLucky();

        if ($skillPointsHomePlayer == $skillPointsAwayPlayer) {
            // en caso de empate se decide si se favorece al local en el juego
            return ($this->isFavorslocals() ? $this->getHomeplayer() : $this->getAwayplayer());
        } else {
            // se declara ganador al que más puntos de habilidad posea
            return ($skillPointsHomePlayer > $skillPointsAwayPlayer ? $this->getHomeplayer() : $this->getAwayplayer());
        }
    }

    /**
     * Calcula y devuelve la sumatoria de las habilidades de un jugador, dependiendo del tipo de torneo que se esté jugando
     *
     * @param Player Jugador del cual se desean obtener los puntos de habilidad
     * @return int Devuelve los puntos de habilidad de un jugador
     */
    public function getPlayerSkillPoints(Player $player): int
    {
        $skillPoints = 0;
        $skillsUsed = $this->getStage()->getTournament()->getTournamentType()->getSkills();
        foreach ($skillsUsed as $skill) {
            $skillPoints += $player->getSkill($skill);
        }
        return $skillPoints;
    }

    /* GETTERS Y SETTERS*/

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
        // controla los límites posibles 0-100
        if ($lucky < 0) {
            $this->lucky = 0;
        } elseif ($lucky > 10) {
            $this->lucky = 10;
        } else {
            $this->lucky = $lucky;
        }

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

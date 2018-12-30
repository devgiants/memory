<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 24/12/18
 * Time: 14:47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Memory\GameStatuses;
use Ramsey\Uuid\UuidInterface;


/**
 * Represent a game with its data
 *
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 * @ORM\Table()
 */
class Game
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /**
     * @var string game status (must be a value from GameStatuses class)
     *
     * @ORM\Column(type="string", length=256)
     */
    protected $status = GameStatuses::IN_PROGRESS;

    /**
     * @var int the time given to finish game
     *
     * @ORM\Column(type="integer")
     */
    protected $timeToFinish;

    /**
     * @var int the time left when game finished
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $timeLeft;

    /**
     * @var \DateTime $startDatethe datetime where game starts
     *
     * @ORM\Column(type="datetime")
     */
    protected $startDate;


    /**
     * Game constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        // Init datetime when game instance is built
        $this->startDate = new \DateTime();
    }

    /**
     * Game start date getter
     * @return \DateTime the start date
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * Game start date setter
     * @param \DateTime $startDate the start date to set for this game
     *
     * @return Game the current game
     */
    public function setStartDate(\DateTime $startDate): Game
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the game UUID
     * @return \Ramsey\Uuid\UuidInterface the game UUID
     */
    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    /**
     * Returns the game status
     * @return string the game status
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set the game status
     * @param string $status the game status to set
     *
     * @return Game the current game
     */
    public function setStatus(string $status): Game
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Returns the time left when game finished
     * @return int the time left
     */
    public function getTimeLeft(): ?int
    {
        return $this->timeLeft;
    }

    /**
     * Set the time left when game finished
     * @param int $timeLeft the time left
     *
     * @return Game the current game
     */
    public function setTimeLeft(int $timeLeft): Game
    {
        $this->timeLeft = $timeLeft;

        return $this;
    }

    /**
     * Returns the time allowed for playing this game
     * @return int the time allowed for playing this game
     */
    public function getTimeToFinish(): int
    {
        return $this->timeToFinish;
    }

    /**
     * Sets the time allowed for playing this game
     * @param int $timeToFinish the time to finish allowed for this game
     *
     * @return Game
     */
    public function setTimeToFinish(int $timeToFinish): Game
    {
        $this->timeToFinish = $timeToFinish;

        return $this;
    }
}
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
     * @var string game status
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
     * @var \DateTime $startDate
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
        $this->startDate = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return Game
     */
    public function setStartDate(\DateTime $startDate): Game
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Game
     */
    public function setStatus(string $status): Game
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeLeft(): ?int
    {
        return $this->timeLeft;
    }

    /**
     * @param int $timeLeft
     *
     * @return Game
     */
    public function setTimeLeft(int $timeLeft): Game
    {
        $this->timeLeft = $timeLeft;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeToFinish(): int
    {
        return $this->timeToFinish;
    }

    /**
     * @param int $timeToFinish
     *
     * @return Game
     */
    public function setTimeToFinish(int $timeToFinish): Game
    {
        $this->timeToFinish = $timeToFinish;

        return $this;
    }
}
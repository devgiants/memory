<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 24/12/18
 * Time: 16:18
 */

namespace App\Handler;

use App\Entity\Game;
use App\Model\CardFlusherInterface;
use App\Model\GameHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Ramsey\Uuid\UuidInterface;

class GameHandler implements GameHandlerInterface
{
    /**
     * @var CardFlusherInterface $cardsFlusher
     */
    protected $cardsFlusher;

    /**
     * @var EntityManagerInterface $entityManager
     */
    protected $entityManager;

    /**
     * @var int $timeToFinish
     */
    protected $timeToFinish;

    /**
     * GameHandler constructor.
     *
     * @param CardFlusherInterface $cardsFlusher
     * @param EntityManagerInterface $entityManager
     * @param int $gameTime
     */
    public function __construct(CardFlusherInterface $cardsFlusher, EntityManagerInterface $entityManager, int $gameTime)
    {
        $this->cardsFlusher = $cardsFlusher;
        $this->entityManager = $entityManager;
        $this->timeToFinish = $gameTime;
    }

    /**
     * @return CardFlusherInterface
     */
    public function getCardsFlusher(): CardFlusherInterface
    {
        return $this->cardsFlusher;
    }


    /**
     * @return Game
     */
    public function create(): Game
    {
        $newGame = new Game($this->timeToFinish);
        $this->entityManager->persist($newGame);
        $this->entityManager->flush();

        return $newGame;
    }

    /**
     * Update a game with given params
     *
     * @param UuidInterface $uuid
     * @param array $gameData
     *
     * @return Game
     */
    public function update(UuidInterface $uuid, array $gameData): Game
    {

        return $game;
    }
}
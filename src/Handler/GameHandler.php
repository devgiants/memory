<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 24/12/18
 * Time: 16:18
 */

namespace App\Handler;

use App\Entity\Game;
use App\Exception\GameStatusException;
use App\Model\CardFlusherInterface;
use App\Model\GameHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Mapping\Entity;
use Memory\GameStatuses;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Serializer\SerializerInterface;

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
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var int $timeToFinish
     */
    protected $timeToFinish;

    /**
     * @var \ReflectionClass
     */
    protected $gameStatusesClassReflection;

    /**
     * GameHandler constructor.
     *
     * @param CardFlusherInterface $cardsFlusher
     * @param EntityManagerInterface $entityManager
     * @param int $gameTime
     *
     * @throws \ReflectionException
     */
    public function __construct(
        CardFlusherInterface $cardsFlusher,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        int $gameTime
    ) {
        $this->cardsFlusher  = $cardsFlusher;
        $this->entityManager = $entityManager;
        $this->serializer    = $serializer;
        $this->timeToFinish  = $gameTime;

        $this->gameStatusesClassReflection = new \ReflectionClass(GameStatuses::class);
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
     * @throws \Exception
     */
    public function create(): Game
    {
        $newGame = new Game();
        $newGame->setTimeToFinish($this->timeToFinish);
        $this->entityManager->persist($newGame);
        $this->entityManager->flush();

        return $newGame;
    }

    /**
     * @param Game $game
     * @param string $serializedGameData
     *
     * @return Game
     */
    public function update(Game $game, string $serializedGameData): Game
    {
        // TODO use Serializer with correct denormalizer
        $gameData = json_decode($serializedGameData);

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        foreach ($gameData as $property => $data) {
            if ($propertyAccessor->isReadable($game, $property)) {

                switch ($property) {
                    case 'status':
                        // Check if status is allowed
                        if (! in_array($data, $this->gameStatusesClassReflection->getConstants())) {
                            throw new GameStatusException("Statusgiven is not allowed : only " . implode(', ',
                                    $this->gameStatusesClassReflection->getConstants()));
                        }
                        break;
                }

                $propertyAccessor->setValue($game, $property, $data);
            }
        }

        $this->entityManager->flush();

        return $game;
    }

    /**
     * @param UuidInterface $uuid
     *
     * @return Game
     * @throws EntityNotFoundException
     */
    protected function findGameByUuid(UuidInterface $uuid)
    {
        $game = $this->entityManager->getRepository(Game::class)->find($uuid);
        if (! $game instanceof Game) {
            throw new EntityNotFoundException();
        }

        return $game;
    }


    /**
     * @return Game[]|array|object[]
     */
    public function getAllGames()
    {
        $games = $this->entityManager->getRepository(Game::class)->findAll();

        return $games;
    }

    /**
     * @param Game $game
     *
     * @throws \Exception
     */
    public function handleLongTermStatus(Game $game)
    {
        $now = new \DateTime();

        // Compare current date/time with start game date/time + time allowed to execute game
        // If result is bigger, it means that game is over
        if ($now > ($game->getStartDate()->add(new \DateInterval("PT{$game->getTimeToFinish()}S")))) {
            // Game is over without finish playing, it is lost
            $game->setStatus(GameStatuses::LOST);
            $this->entityManager->flush();
        }
    }
}
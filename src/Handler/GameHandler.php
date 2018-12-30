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
use Memory\GameStatuses;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class GameHandler
 * This class handles all actions around a game
 *
 * @package App\Handler
 */
class GameHandler implements GameHandlerInterface
{
    /**
     * @var CardFlusherInterface $cardsFlusher the card flushe object
     */
    protected $cardsFlusher;

    /**
     * @var EntityManagerInterface $entityManager the entity manager used
     */
    protected $entityManager;

    /**
     * @var int $timeToFinish the time to finish
     */
    protected $timeToFinish;

    /**
     * @var \ReflectionClass Reflection class for manpulating constants
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
        int $gameTime
    ) {
        // Make assignations for attributes
        $this->cardsFlusher  = $cardsFlusher;
        $this->entityManager = $entityManager;
        $this->timeToFinish  = $gameTime;

        // Create reflection class instance
        $this->gameStatusesClassReflection = new \ReflectionClass(GameStatuses::class);
    }

    /**
     * Get time to finish for handled games
     * @return int the time to finish
     */
    public function getTimeToFinish(): int
    {
        return $this->timeToFinish;
    }

    /**
     * Get the card flusher object
     * @return CardFlusherInterface the card flusher object
     */
    public function getCardsFlusher(): CardFlusherInterface
    {
        return $this->cardsFlusher;
    }


    /**
     * Creates a new game
     * @return Game the created game
     * @throws \Exception throwed if game persists fails
     */
    public function create(): Game
    {
        $newGame = new Game();
        $newGame->setTimeToFinish($this->timeToFinish);
        $newGame->setStartDate(new \DateTime('now'));

        $this->entityManager->persist($newGame);
        $this->entityManager->flush();

        return $newGame;
    }

    /**
     * Update a game with given data
     * @param Game $game the game to update
     * @param string $serializedGameData serialized data for game update
     *
     * @return Game
     */
    public function update(Game $game, string $serializedGameData): Game
    {
        // TODO use Serializer with correct denormalizer
        $gameData = json_decode($serializedGameData);

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        // Loop to update data
        foreach ($gameData as $property => $data) {

            //if propertyAccessor says it exists
            if ($propertyAccessor->isReadable($game, $property)) {

                // Pre-checks
                switch ($property) {
                    case 'status':
                        // Check if status is allowed
                        if (! in_array($data, $this->gameStatusesClassReflection->getConstants())) {
                            throw new GameStatusException("Status given is not allowed : only " . implode(', ',
                                    $this->gameStatusesClassReflection->getConstants()));
                        }
                        break;
                }

                // Final update
                $propertyAccessor->setValue($game, $property, $data);
            }
        }

        // Persists
        $this->entityManager->flush();

        return $game;
    }

    /**
     * Returns all games from database
     * @return Game[]|array|object[] the game ArrayCollection
     */
    public function getAllGames()
    {
        $games = $this->entityManager->getRepository(Game::class)->findAll();

        return $games;
    }

    /**
     * Change game status if first access player quit before end
     * @param Game $game the game concerned
     *
     * @throws \Exception if persist problem
     */
    public function handleLongTermStatus(Game $game)
    {
        $now = new \DateTime();

        // Compare current date/time with start game date/time + time allowed to execute game
        // If result is bigger, it means that game is over
        if ($now > ($game->getStartDate()->add(new \DateInterval("PT{$game->getTimeToFinish()}S")))) {
            // Game is over without finish playing, it is lost
            $game->setStatus(GameStatuses::LOST);
            // Lost by time, so 0 left
            $game->setTimeLeft(0);
            $this->entityManager->flush();
        }
    }

    /**
     * @param UuidInterface $uuid the UUID game to find
     *
     * @return Game the game found
     * @throws EntityNotFoundException if no game found
     */
    protected function findGameByUuid(UuidInterface $uuid)
    {
        $game = $this->entityManager->getRepository(Game::class)->find($uuid);
        if (! $game instanceof Game) {
            throw new EntityNotFoundException();
        }

        return $game;
    }
}
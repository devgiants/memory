<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 28/12/18
 * Time: 11:17
 */

namespace App\Tests\Handler;


use App\Entity\Game;
use App\Model\CardFlusherInterface;
use App\Model\GameHandlerInterface;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GameHandlerTest
 *
 * @package App\Tests\Handler
 */
class GameHandlerTest extends WebTestCase
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var GameHandlerInterface
     */
    protected $gameHandler;

    /**
     * @var Game $testGame
     */
    protected $testGame;

    /**
     * @var int
     */
    protected $timeToFinish;


    protected function setUp()
    {
        parent::setUp();

        // Get Kernel
        self::bootKernel();
        $this->container = self::$kernel->getContainer();

        // Init gameHandler attribute
        $this->gameHandler = $this->container->get('app.game_handler');
//        $this->gameHandler = $this->createMock(GameHandler::class);

        $this->timeToFinish = $this->container->getParameter('game_time');
    }

    /**
     * Test create new game method
     * @throws \Exception
     */
    // TODO export in repository to allow mock testing
//    public function testCreateNewGame()
//    {
//
//        $game = $this->gameHandler->create();
//
//        // Game var should be instance of Game class
//        Assert::assertInstanceOf(Game::class, $game);
//
//        // Game should have a UUID, meaning it's persisted
//        Assert::assertNotNull($game->getId());
//
//        // Time to finish specified in GameHandler should be the one provided to the game
//        Assert::assertEquals($this->gameHandler->getTimeToFinish(), $game->getTimeToFinish());
//    }

    /**
     * Check card flusher returns a CardFlusherInterface
     */
    public function testGetCardFlusher()
    {
        $cardFlusher = $this->gameHandler->getCardsFlusher();

        Assert::assertInstanceOf(CardFlusherInterface::class, $cardFlusher);
    }

    /**
     * Check getTimeToFinish returns correct parameter
     */
    public function testGetTimeToFinish()
    {
        $timeToFinish = $this->gameHandler->getTimeToFinish();

        Assert::assertEquals($this->timeToFinish, $timeToFinish);
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}
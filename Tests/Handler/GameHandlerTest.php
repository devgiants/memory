<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 28/12/18
 * Time: 11:17
 */

namespace App\Tests\Handler;


use App\Entity\Game;
use App\Handler\GameHandler;
use App\Model\GameHandlerInterface;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GameHandlerTest
 *
 * @package App\Tests\Handler
 */
class GameHandlerTest extends WebTestCase
{
    /**
     * @var GameHandlerInterface
     */
    protected $gameHandler;

    /**
     * @var Game $testGame
     */
    protected $testGame;

    /**
     * GameHandlerTest constructor.
     *
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        // Get Kernel
        self::bootKernel();
        $container = self::$kernel->getContainer();

        // Init gameHandler attribute
        $this->gameHandler = $container->get('app.game_handler');
//        $this->gameHandler = $this->createMock(GameHandler::class);
    }

    /**
     * Test create new game method
     * @throws \Exception
     */
    public function testCreateNewGame()
    {

        $game = $this->gameHandler->create();

        // Game var should be instance of Game class
        Assert::assertInstanceOf(Game::class, $game);

        // Game should have a UUID, meaning it's persisted
        Assert::assertNotNull($game->getId());

        // Time to finish specified in GameHandler should be the one provided to the game
        Assert::assertEquals($this->gameHandler->getTimeToFinish(), $game->getTimeToFinish());
    }


}
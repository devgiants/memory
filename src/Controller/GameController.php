<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 20/12/18
 * Time: 14:28
 */

namespace App\Controller;

use App\Entity\Game;
use App\Model\GameHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GameController
 *
 * @package App\Controller
 * @author Nicolas BONNIOT <nicolas@devgiants.fr<
 */
class GameController extends AbstractController
{
    /**
     * Starts a new game
     *
     * @param GameHandlerInterface $gameHandler
     * @return Response
     * @Route("/new-game", name="app_new_game")
     */
    public function newGame(GameHandlerInterface $gameHandler): Response
    {
        // Creates and persist new game
        $newGame = $gameHandler->create();

        return $this->redirectToRoute('app_game', ['uuid' => $newGame->getId()]);
    }

    /**
     * Allow to display a game
     *
     * @param Game $game
     * @param GameHandlerInterface $gameHandler
     *
     * @ParamConverter("game", options={"mapping": {"uuid": "id"}})
     * @return Response
     * @Route("/game/{uuid}", name="app_game")
     */
    public function displayGame(Game $game, GameHandlerInterface $gameHandler): Response
    {
        $cardsFlusher = $gameHandler->getCardsFlusher();

        return $this->render(
            '@App/game/game.html.twig',
            [
                'cards'    => $cardsFlusher->shuffle(),
                'game' => $game
            ]
        );
    }
}
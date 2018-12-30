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
use Memory\GameStatuses;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GameController
 * All actions around Game.
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
     *
     * @return Response
     * @Route("/new-game", name="app_new_game")
     */
    public function newGame(GameHandlerInterface $gameHandler): Response
    {
        // Creates and persist new game
        $newGame = $gameHandler->create();

        // Redirect to unique route linked to this game
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
        // Verify and update game status if necessary
        $gameHandler->handleLongTermStatus($game);

        // Start args for view rendering
        $args = [
            'game'  => $game
        ];

        // Only is game is still in progress, get cards
        if(GameStatuses::IN_PROGRESS === $game->getStatus()) {
            $cardsFlusher = $gameHandler->getCardsFlusher();

            //Add them for a view
            $args['cards'] = $cardsFlusher->shuffle();
        }

        // Render view
        return $this->render(
            '@App/game/game.html.twig',
            $args
        );
    }

    /**
     * Display games list
     * @param GameHandlerInterface $gameHandler
     *
     * @return Response
     * @Route("/games", name="app_show_games")
     */
    public function displayGames(GameHandlerInterface $gameHandler) : Response
    {
        // TODO add pagination
        $games = $gameHandler->getAllGames();

        return $this->render(
            '@App/game/games.html.twig',
            [
                'games' => $games
            ]
        );
    }
}
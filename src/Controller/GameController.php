<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 20/12/18
 * Time: 14:28
 */

namespace App\Controller;

use App\Entity\Game;
use App\Game\CardFlusher;
use App\Model\CardFlusherInterface;
use App\Model\GameHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
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
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route("/new-game", name="app_new_game")
     */
    public function newGame(EntityManagerInterface $entityManager): Response
    {
        // Creates and persist new game
        $newGame = new Game();
        $entityManager->persist($newGame);
        $entityManager->flush();


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

        $cardsFlusher->init($this->getParameter('available_cards'));

        return $this->render(
            '@App/game/game.html.twig',
            [
                'cards'    => $cardsFlusher->shuffle(),
                'gameTime' => $this->getParameter('game_time')
            ]
        );
    }
}
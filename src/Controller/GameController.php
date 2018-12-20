<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 20/12/18
 * Time: 14:28
 */

namespace App\Controller;

use Memory\CardFlusher;
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
     * Allow to start a new game
     *
     * @return Response
     * @Route("/new-game", name="app_new_game")
     */
    public function newGame(): Response
    {
        $cardsFlusher = new CardFlusher($this->getParameter('available_cards'));

        return $this->render(
            '@App/game/game.html.twig',
            ['cards' => $cardsFlusher->flush()]
        );
    }
}
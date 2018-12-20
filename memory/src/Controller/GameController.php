<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 20/12/18
 * Time: 14:28
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameController
 *
 * @package App\Controller
 */
class GameController extends AbstractController
{
    /**
     * @Route("/new-game", name="app_new_game")
     */
    public function newGame()
    {
        return $this->render('@App/game/game.html.twig');
    }
}
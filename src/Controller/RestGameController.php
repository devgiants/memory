<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 26/12/18
 * Time: 10:05
 */

namespace App\Controller;


use App\Model\GameHandlerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

class RestGameController extends FOSRestController
{

    /**
     * @param array $gameData
     * @param ParamFetcherInterface $paramFetcher
     * @param GameHandlerInterface $gameHandler
     * @return View amended view with new post link in header
     *
     * @Rest\Put("/api/game/{uuid}", name="game_rest_update")
     */
    public function updateGame(array $gameData, ParamFetcherInterface $paramFetcher, GameHandlerInterface $gameHandler) : View
    {
        $gameUuid = Uuid::fromString($paramFetcher->get('uuid'));

        $game = $gameHandler->update($gameUuid, $gameData);
        // Return amended view for links purpose
        return $this->view(
            $game,
            Response::HTTP_OK, [
                'Location' => $this->generateUrl(
                    'app_game', [
                        'uuid' => $game->getId(),
                        UrlGeneratorInterface::ABSOLUTE_URL
                    ]
                )
            ]
        );
    }
}
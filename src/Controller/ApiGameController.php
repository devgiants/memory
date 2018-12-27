<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 26/12/18
 * Time: 10:05
 */

namespace App\Controller;


use App\Entity\Game;
use App\Model\GameHandlerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;;
use JMS\Serializer\SerializerInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class ApiGameController
 *
 * @package App\Controller
 */
class ApiGameController extends FOSRestController
{

    /**
     * @param Request $request
     * @param Game $game
     * @param GameHandlerInterface $gameHandler
     *
     * @return View amended view with new post link in header
     *
     * @Rest\Put("/api/game/{uuid}", name="game_rest_update", requirements={"uuid"="\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b"})
     * @ParamConverter("game", options={"id" = "uuid"})
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function updateGameStatus(Request $request, Game $game, GameHandlerInterface $gameHandler) : View
    {
        // TODO use another ParamConverter for array, not working so far.

        $game = $gameHandler->update($game, $request->getContent());
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
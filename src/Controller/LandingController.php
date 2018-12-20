<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 20/12/18
 * Time: 15:17
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LandingController
 *
 * @package App\Controller
 */
class LandingController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     * @return Response
     */
    public function index() : Response
    {
        return $this->render('@App/landing.html.twig', []);
    }
}
<?php
namespace App\Controller\Add;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AddController extends AbstractController {

    /**
     * @Route("/add", methods={"GET"})
     */
    public function add() {
        return new Response('AddController::add');
    }

}

























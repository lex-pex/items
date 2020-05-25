<?php

namespace App\Controller\Serve;

/* // use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; */
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class TemplateController is a blueprint that serves
 * as a basis for creating each new controller
 * @package App\Controller
 */
class TemplateController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index() {
        return $this->render(
            'default/sample.html.twig',
            [
                'message' => 'Message from DefaultController',
                'title' => 'Title from DefaultController',
            ]);
    }

    public function indexAction() {
        return $this->render(
            'default/sample.html.twig',
            //'base.html.twig',
            [
                'message' => 'Message from DefaultController',
                'title' => 'Title from DefaultController',
            ]);
    }

}



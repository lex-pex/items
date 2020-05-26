<?php
namespace App\Controller\Add;

//use Sesio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use App\Model\Person;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController {

    /**
     * Sample Action by Route from Yaml-file
     * @return Response
     */
    public function indexAction() {
        return new Response('indexAction');
    }

    /**
     * @Route("/hello", methods={"GET"})
     */
    public function index() {
        return new Response('Hello, World');
    }

    /**
     * @Route("/test", methods={"GET"})
     */
    public function test() {
        return $this->render('default/test.html.twig', [
            'message' => 'Message from Controller',
            'flag' => 0
        ]);
    }

    /**
     * @Route("/person/objects", methods={"GET"})
     */
    public function person() {
        return $this->render(
            'default/person.html.twig', [
                'message' => 'Objects List',
                'persons' => Person::createList(),
                'flag' => 0
            ]);
    }

    /**
     * @Route("/person/resource/objects", methods={"POST"})
     */
    public function personResource() {
        return new Response(
            json_encode(Person::createList())
        );
    }

    /**
     * @Route("/poster/resource", methods={"POST"})
     */
    public function postResource() {
        $nestedObject = new \stdClass();
        $nestedObject->id = 55;
        $nestedObject->title = 'Mock Object';
        $nestedObject->array = ['one', 'two', 'three'];
        $data = [
            'id' => 245,
            'name' => 'Center',
            'code' => 'Secret',
            'set' => [
                34, 'unit'
            ],
            'obj' => $nestedObject
        ];
        return new Response(
            json_encode($data)
        );
    }

    /**
     * @Route("/lucky/number")
     */
    public function number()
    {
        $number = random_int(0, 100);
        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

}


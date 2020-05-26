<?php
namespace App\Controller\Blog;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\BlogCategory;


class CategoryController extends AbstractController {

    /**
     * @Route("/categories/search", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $pattern = $request->get('pattern');
        $doctrine = $this->getDoctrine();
        $categories = $doctrine
            ->getRepository(BlogCategory::class)
            ->findBy(['name' => $pattern]);
        return $this->render(
            'cats/index.html.twig', [
            'categories' => $categories,
            'title' => 'Search Categories'
        ]);
    }

    /**
     * @Route("/categories", methods={"GET"})
     */
    public function index()
    {
        $doctrine = $this->getDoctrine();
        $categories = $doctrine
            ->getRepository(BlogCategory::class)
            ->findAll();
        return $this->render(
            'cats/index.html.twig', [
            'categories' => $categories,
            'title' => 'Categories'
        ]);
    }

    /**
     * @Route("/categories/{id}/edit", methods={"GET"})
     * @return Response
     */
    public function edit($id)
    {
        $doctrine = $this->getDoctrine();
        $category = $doctrine
            ->getRepository(BlogCategory::class)
            ->find($id);
        return $this->render(
            'cats/edit.html.twig', [
            'category' => $category,
            'title' => 'Create Category Form'
        ]);
    }

    /**
     * @Route("/categories/update", methods={"post"})
     * @param Request $request
     * @return Response
     */
    public function update(Request $request) {
        $id = $request->get('id');
        $doctrine = $this->getDoctrine();
        $category = $doctrine
            ->getRepository(BlogCategory::class)
            ->find($id);
        $name = $request->get('name');
        $category->setName($name);
        $doctrine = $this->getDoctrine();
        $doctrine->getManager()->persist($category);
        $doctrine->getManager()->flush();
        return $this->render(
            'cats/show.html.twig', [
            'category' => $category,
            'title' => 'New Edited Category'
        ]);
    }

    /**
     * @Route("/categories/create", methods={"GET"})
     * @return Response
     */
    public function create()
    {
        return $this->render(
            'cats/create.html.twig', [
            'title' => 'Create Category Form'
        ]);
    }

    /**
     * @Route("/categories/store", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $category = new BlogCategory();
        $name = $request->get('name');
        $category->setName($name);
        $doctrine = $this->getDoctrine();
        $doctrine->getManager()->persist($category);
        $doctrine->getManager()->flush();
        return $this->render(
            'cats/show.html.twig', [
            'category' => $category,
            'title' => 'New Created Category'
        ]);
    }

    /**
     * @Route("/categories", methods={"DELETE"})
     * @return Response
     */
    public function destroy(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $m = $doctrine->getManager();
        $id = $request->get('id');
        $category = $m->find(BlogCategory::class, $id);
        $m->remove($category);
        $m->flush();
        return $this->redirect('/categories');
    }

    /**
     * @Route("/categories/{id}", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        if(!$id || !is_numeric($id)) {
            return new Response(
            '<h1 style="text-align:center">There is no such page... sorry</h1>');
        }
        $doctrine = $this->getDoctrine();
        $category = $doctrine
            ->getRepository(BlogCategory::class)
            ->find($id);
        return $this->render(
            'cats/show.html.twig', [
            'category' => $category,
            'title' => 'Show Category'
        ]);
    }
}






























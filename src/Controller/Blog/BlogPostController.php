<?php
namespace App\Controller\Blog;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\BlogPost;


class BlogPostController extends AbstractController {

    /**
     * @Route("/posts/search", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $pattern = $request->get('pattern');
        $doctrine = $this->getDoctrine();
        $posts = $doctrine
            ->getRepository(BlogPost::class)
            ->findBy(['name' => $pattern]);
        return $this->render(
            'posts/index.html.twig', [
            'posts' => $posts,
            'title' => 'Search Posts'
        ]);
    }

    /**
     * @Route("/posts", methods={"GET"})
     */
    public function index()
    {
        $doctrine = $this->getDoctrine();
        $posts = $doctrine
            ->getRepository(BlogPost::class)
            ->findAll();
        return $this->render(
            'posts/index.html.twig', [
            'posts' => $posts,
            'title' => 'Posts',
        ]);
    }

    /**
     * @Route("/posts/{id}/edit", methods={"GET"})
     * @return Response
     */
    public function edit($id)
    {
        $doctrine = $this->getDoctrine();
        $post = $doctrine
            ->getRepository(BlogPost::class)
            ->find($id);
        return $this->render(
            'posts/edit.html.twig', [
            'post' => $post,
            'title' => 'Create Post Form'
        ]);
    }

    /**
     * @Route("/posts/update", methods={"post"})
     * @param Request $request
     * @return Response
     */
    public function update(Request $request) {
        $id = $request->get('id');
        $doctrine = $this->getDoctrine();
        $post = $doctrine
            ->getRepository(BlogPost::class)
            ->find($id);
        $name = $request->get('name');
        $post->setName($name);
        $doctrine = $this->getDoctrine();
        $doctrine->getManager()->persist($post);
        $doctrine->getManager()->flush();
        return $this->render(
            'posts/show.html.twig', [
            'post' => $post,
            'title' => 'New Edited Post'
        ]);
    }

    /**
     * @Route("/posts/create", methods={"GET"})
     * @return Response
     */
    public function create()
    {
        return $this->render(
            'posts/create.html.twig', [
            'title' => 'Create Post Form'
        ]);
    }

    /**
     * @Route("/posts/store", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $post = new BlogPost();
        $name = $request->get('name');
        $post->setName($name);
        $doctrine = $this->getDoctrine();
        $doctrine->getManager()->persist($post);
        $doctrine->getManager()->flush();
        return $this->render(
            'posts/show.html.twig', [
            'post' => $post,
            'title' => 'New Created Post'
        ]);
    }

    /**
     * @Route("/posts", methods={"DELETE"})
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        return new Response("destroy: " . $request->get('id'));

        $doctrine = $this->getDoctrine();
        $m = $doctrine->getManager();
        $id = $request->get('id');
        $post = $m->find(BlogPost::class, $id);
        $m->remove($post);
        $m->flush();
        return $this->redirect('/categories');
    }

    /**
     * @Route("/posts/{id}", methods={"GET"})
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
        $post = $doctrine
            ->getRepository(BlogPost::class)
            ->find($id);
        return $this->render(
            'posts/show.html.twig', [
            'post' => $post,
            'title' => 'Show Post'
        ]);
    }
}






























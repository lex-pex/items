<?php
namespace App\Controller\Blog;

use App\Entity\BlogCategory;
use DateTimeImmutable;
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
            ->findBy([], ['id'=>'desc']);
        $cats = $doctrine
            ->getRepository(BlogCategory::class)
            ->findBy([], ['id'=>'asc']);
        $categories = [];
        for($i = 0; $i < count($cats); $i++) {
            $categories[$cats[$i]->getId()] = $cats[$i]->getName();
        }
        return $this->render(
            'posts/index.html.twig', [
            'posts' => $posts,
            'categories' => $categories,
            'category' => 0,
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
        $cats = $doctrine
            ->getRepository(BlogCategory::class)
            ->findAll();
        $categories = [];
        for($i = 0; $i < count($cats); $i++) {
            $categories[$cats[$i]->getId()] = $cats[$i]->getName();
        }
        return $this->render(
            'posts/edit.html.twig', [
            'post' => $post,
            'categories' => $categories,
            'category' => $post->getCategoryId(),
            'title' => 'Edit Post Form'
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

        $title = $request->get('title');
        $content = $request->get('content');
        $category = $request->get('category_id');

        $post->setTitle($title);
        $post->setContent($content);
        $post->setCategoryId($category);

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
        $doctrine = $this->getDoctrine();
        $cats = $doctrine
            ->getRepository(BlogCategory::class)
            ->findAll();
        $categories = [];
        for($i = 0; $i < count($cats); $i++) {
            $categories[$cats[$i]->getId()] = $cats[$i]->getName();
        }
        return $this->render(
            'posts/create.html.twig', [
            'categories' => $categories,
            'category' => 0,
            'title' => 'Create Post Form',
        ]);
    }

    /**
     * @Route("/posts/store", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $post = new BlogPost();
        $title = $request->get('title');
        $content = $request->get('content');
        $category = $request->get('category_id');

        $post->setTitle($title);
        $post->setContent($content);
        $post->setCategoryId($category);
        $post->setCreated(new DateTimeImmutable(date('Y-m-d')));

        $doctrine = $this->getDoctrine();
        $doctrine->getManager()->persist($post);
        $doctrine->getManager()->flush();

        return $this->redirect('/posts/' . $post->getId());
    }

    /**
     * @Route("/posts", methods={"DELETE"})
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        return new Response(
            'You try to delete item: #' . $request->get('id')
        );
        die();
        $doctrine = $this->getDoctrine();
        $m = $doctrine->getManager();
        $id = $request->get('id');
        $post = $m->find(BlogPost::class, $id);
        $m->remove($post);
        $m->flush();
        return $this->redirect('/posts');
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
        $cats = $doctrine
            ->getRepository(BlogCategory::class)
            ->findBy([], ['id'=>'asc']);
        $categories = [];
        for($i = 0; $i < count($cats); $i++) {
            $categories[$cats[$i]->getId()] = $cats[$i]->getName();
        }
        return $this->render(
            'posts/show.html.twig', [
            'post' => $post,
            'categories' => $categories,
            'category' => $post->getCategoryId(),
            'title' => 'Show Post'
        ]);
    }
}






























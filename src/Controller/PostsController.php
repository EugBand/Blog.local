<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{


    /** @var PostRepository $postRepository */
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/posts", name="blog_posts")
     */
    public function posts()
    {
        $posts = $this->postRepository->findAll();
        return $this->render('posts/index.html.twig',
            ['posts' => $posts]);
    }


    /**
     * @Route("/posts", name="posts")
     */
    public function index()
    {
        $posts = [
            'post_1' => [
                'title' => 'Заголовок первого поста',
                'body' => 'Тело первого поста'
            ],
            'post_2' => [
                'title' => 'Заголовок второго поста',
                'body' => 'Тело второго поста'
            ]
        ];
        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/posts/new", name="new_blog_post")
     */
    public function addPost(Request $request, Slugify $slugify)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug($slugify->slugify($post->getTitle()));
            $post->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog_posts');
        }
        return $this->render('posts/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/posts/{slug}/edit", name="blog_post_edit")
     */
    public function edit(Post $post, Request $request, Slugify $slugify){
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $post->setSlug($slugify->slugify($post->getTitle()));
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('posts', ['slug' => $post->getSlug()]);
            }
        return $this->render('posts/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/post/{slug}/delete", name="blog_post_delete")
     */
    public function delete(Post $post){
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute("blog_posts");
    }

    /**
     * @Route("/posts/search", name="blog_search")
     */
    public function search(Request $request)
    {
        $query = $request->query->get('q');
        $posts = $this->postRepository->searchByQuery($query);
        var_dump($posts);

        return $this->render('blog/query_post.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/post/{slug}", name="blog_show")
     */

    public function show(Post $post)
    {
        return $this->render('posts/show.html.twig',
            ['post' => $post]);
    }

}


<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post', name: 'post.')]
class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        dump($posts);
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/create', name: 'create', methods: [])]
    public function create(ManagerRegistry $doctrine): Response
    {


        $post = new Post();
        $post->setTitle('Title_1');
        $post->setDescription('Description_1');

        $entityManager = $doctrine->getManager();
        $entityManager->persist($post);
        $entityManager->flush();


        return new Response('Post was created');
    }


    #[Route('/show/{id}', name: 'show', methods: [])]
    public function show(Post $post): Response
    {
        /*  $post = $postRepository->find($id);*/
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }


    #[Route('/delete/{id}', name: 'delete', methods: ["DELETE"])]
    public function delete(Post $post,ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('post.index'));
    }



    #[Route('/update/{id}', name: 'update', methods: [])]
    public function update(Post $post,ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('post.index'));
    }


}

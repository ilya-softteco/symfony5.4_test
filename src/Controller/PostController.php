<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
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

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('post')['image'];
            if ($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();

                $file->move(
                    $this->getParameter('upload_dir'),
                    $fileName
                );
                $post->setImage($fileName);
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'Post was added');

            return $this->redirect($this->generateUrl('post.index'));
        }

        /*  $post->setTitle('Title_1');
          $post->setDescription('Description_1');

          $entityManager = $doctrine->getManager();
          $entityManager->persist($post);
          $entityManager->flush();*/


        return $this->render('post/create.html.twig', [
            //'posts' => $posts,
            'form' => $form->createView(),
        ]);

        // return $this->redirect($this->generateUrl('post.index'));
    }


    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        /*  $post = $postRepository->find($id);*/
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }


    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Post $post, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        $pathFile = $this->getParameter('upload_dir') . $post->getImage();

        if (file_exists($pathFile)) {
            unlink($pathFile);
        }

        $this->addFlash('success', 'Post was removed');

        return $this->redirect($this->generateUrl('post.index'));
    }


    #[Route('/update/{id}', name: 'update')]
    public function update(Post $post, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        if (!$post) {
            throw $this->createNotFoundException(
                'No product found for id ' . $post->getId()
            );
        }

        $post->setTitle('New product title!' . uniqid());
        $post->setDescription('New product Description' . uniqid());
        $entityManager->flush();

        return $this->redirect($this->generateUrl('post.show', ['id' => $post->getId()]));


        // return $this->redirect($this->generateUrl('post.index'));
    }


}

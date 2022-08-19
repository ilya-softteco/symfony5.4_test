<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello/{message}', name: 'app_hello')]
    public function index(string $message = ''): Response
    {
        $em = $this->getDoctrine()->getManager();
        $connected = $em->getConnection()->isConnected();

        dd(rad2deg($connected));

        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
            'message' => !empty($message) ? $message : 'Hello World',
        ]);
    }
}

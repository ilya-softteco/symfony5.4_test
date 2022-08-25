<?php

namespace App\Controller\Api\v1\Trello;

use App\Controller\Api\v1\BaseController;
use App\Entity\Trello\Desk;
use App\Repository\Trello\DeskRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeskController extends BaseController
{
    #[Route('/desk', name: 'all', methods: ['GET'])]
    public function index(DeskRepository $postRepository): Response
    {
        $desks = $postRepository->findAll();
        return $this->json($desks);
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);


            $desk = new Desk();
            $desk->setName($parametersAsArray['name']);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($desk);
            $entityManager->flush();

            return $this->json($desk->getId());

        }
        return $this->json(false);

    }
}

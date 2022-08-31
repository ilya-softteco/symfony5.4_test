<?php

namespace App\Controller\Api\v1\Trello;

use App\Entity\Trello\Desk;
use App\Entity\Trello\Status;
use App\Repository\Trello\DeskRepository;
use App\Repository\Trello\StatusRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/status', name: 'status.')]

class StatusController extends AbstractController
{
    #[Route('/', name: 'all', methods: ['GET'])]
    public function index(StatusRepository $postRepository): Response
    {

        $status = $postRepository->findAll();
        return $this->json($status);
    }



    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(ManagerRegistry $doctrine, Request $request,DeskRepository $deskRepository): Response
    {
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);


            $status = new Status();

            $status->setName($parametersAsArray['name']);
            $desk = $deskRepository->find($parametersAsArray['desk_id']);
            $status->setDesk($desk);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($status);
            $entityManager->flush();

            return $this->json($status->getId());

        }
        return $this->json(false);

    }

}

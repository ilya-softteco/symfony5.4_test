<?php

namespace App\Controller\Api\v1\Trello;

use App\Entity\Trello\Card;
use App\Entity\Trello\Status;
use App\Repository\Trello\CardRepository;
use App\Repository\Trello\DeskRepository;
use App\Repository\Trello\StatusRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/', name: 'trello.')]
class CardController extends AbstractController
{
    #[Route('card', name: 'app_card')]
    public function index(CardRepository $cardRepository): Response
    {
        $cards = $cardRepository->findAll();
        return $this->json($cards);
    }


    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(ManagerRegistry $doctrine, Request $request,StatusRepository $statusRepository): Response
    {
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);


            $card = new Card();

            $card->setName($parametersAsArray['name']);
            $status = $statusRepository->find($parametersAsArray['status_id']);
            $card->setDesk($status);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($card);
            $entityManager->flush();

            return $this->json($card->getId());

        }
        return $this->json(false);

    }
}

<?php

namespace App\Controller\Api\v1\Trello;

use App\Controller\Api\v1\BaseController;
use App\Repository\Trello\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/', name: 'trello.')]
class TaskController extends BaseController
{
    #[Route('task', name: 'app_task')]

    public function index(TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findAll();
        return $this->json($tasks);
    }
}

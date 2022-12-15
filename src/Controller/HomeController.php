<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;

class HomeController extends AbstractController {

    #[Route('/', name: 'app_index')]
    public function index(ManagerRegistry $doctrine): Response { 
        /**
         * @var PostRepository
         */
        $repo = $doctrine->getRepository(Post::class);
        $posts = $repo->findAllTrending();
        return $this->render('index.html.twig', [
            'posts'=>$posts,
        ]);
    }
}
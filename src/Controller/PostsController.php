<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController {

    #[Route('/post/new/', name: 'new_post')]
    public function new(): Response {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        return $this->renderForm('posts/new.html.twig', [
            'form'=>$form
        ]);
    }
}
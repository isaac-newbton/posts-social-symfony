<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostStatus;
use App\Form\PostType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;

class PostsController extends AbstractController {

    #[Route('/post/new/', name: 'new_post')]
    public function new(Request $request, ManagerRegistry $doctrine): Response {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $post = $form->getData();
            $post->setTime(new DateTime('now'));
            $post->setAuthor($this->getUser());
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('app_index');
        }

        return $this->renderForm('posts/new.html.twig', [
            'form'=>$form
        ]);
    }

    #[Route('/post/status/{encoded}', name: 'post_status')]
    public function status(ManagerRegistry $doctrine, string $encoded): Response {
        /**
         * @var PostRepository
         */
        $repo = $doctrine->getRepository(Post::class);
        $post = $repo->findOneByEncodedUuid($encoded);

        if(!$post) {
            throw $this->createNotFoundException('No post found for "' . $encoded . '"');
        }

        return $this->render('posts/status.html.twig', [
            'post'=>$post
        ]);
    }

    #[Route('/post/list', name: 'posts_list')]
    public function list(ManagerRegistry $doctrine): Response {
        $posts = $doctrine->getRepository(Post::class)->findAll();
        return $this->render('posts/admin/list.html.twig', [
            'posts'=>$posts
        ]);
    }

    #[Route('/post/delete/{uuid}', name: 'post_delete')]
    public function delete(ManagerRegistry $doctrine, string $uuid): Response {
        /**
         * @var PostRepository
         */
        $repo = $doctrine->getRepository(Post::class);
        $post = $repo->findOneBy(['uuid'=>$uuid]);

        if(!$post) {
            throw $this->createNotFoundException('No post found for "' . $uuid . '"');
        }

        $entityManager = $doctrine->getManager();

        $post->setStatus(PostStatus::DELETED);

        $entityManager->persist($post);
        $entityManager->flush();

        return $this->redirectToRoute('posts_list');
    }
}
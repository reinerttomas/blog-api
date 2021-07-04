<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/posts/', name: 'post_list')]
    public function list(): Response
    {
        return $this->json(['post_list']);
    }

    #[Route('/posts/{id}', name: 'post_by_id')]
    public function postById(): Response
    {
        return $this->json(['post_by_id']);
    }

    #[Route('/posts/{slug}', name: 'post_by_slug')]
    public function postBySlug(): Response
    {
        return $this->json(['post_by_slug']);
    }

    #[Route('/posts/add', name: 'post_add')]
    public function postAdd(): Response
    {
        return $this->json(['post_add']);
    }
}
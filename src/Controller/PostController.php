<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/posts/', name: 'post_list', methods: 'GET')]
    public function list(): Response
    {
        return $this->json(['post_list']);
    }

    #[Route('/posts/{id<\d+>}', name: 'post_by_id', methods: 'GET')]
    public function postById(int $id): Response
    {
        return $this->json(['post_by_id' => $id]);
    }

    #[Route('/posts/{slug}', name: 'post_by_slug', methods: 'GET')]
    public function postBySlug(string $slug): Response
    {
        return $this->json(['post_by_slug' => $slug]);
    }

    #[Route('/posts/', name: 'post_add', methods: 'POST')]
    public function postAdd(): Response
    {
        return $this->json(['post_add']);
    }
}
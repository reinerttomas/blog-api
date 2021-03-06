<?php
declare(strict_types=1);

namespace App\Controller;

use Blog\Exception\Exception;
use Blog\Exception\NotFoundException;
use Blog\Factory\Api\PostRequestFactory;
use Blog\Factory\PaginatorFactory;
use Blog\Services\PostService;
use ReinertTomas\Utils\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    private PostService $postService;
    private PostRequestFactory $postRequestFactory;
    private PaginatorFactory $paginatorFactory;

    public function __construct(
        PostService $postService,
        PostRequestFactory $postRequestFactory,
        PaginatorFactory $paginatorFactory,
    ) {
        $this->postService = $postService;
        $this->postRequestFactory = $postRequestFactory;
        $this->paginatorFactory = $paginatorFactory;
    }

    #[Route('/posts', name: 'post_list', methods: 'GET')]
    public function list(Request $request): Response
    {
        $paginator = $this->paginatorFactory->create($request);

        $posts = $this->postService->list($paginator);

        return $this->json(
            [
                'page' => $paginator->getPage(),
                'limit' => $paginator->getLimit(),
                'data' => $posts,
            ],
        );
    }

    #[Route('/posts/{id<\d+>}', name: 'post_by_id', methods: 'GET')]
    public function postById(int $id): Response
    {
        try {
            $post = $this->postService->get($id);
        } catch (NotFoundException $e) {
            // @todo - vratit json s chybou
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->json($post);
    }

    #[Route('/posts/{slug}', name: 'post_by_slug', methods: 'GET')]
    public function postBySlug(string $slug): Response
    {
        try {
            $post = $this->postService->getBySlug($slug);
        } catch (NotFoundException $e) {
            // @todo - vratit json s chybou
            throw $this->createNotFoundException($e->getMessage());
        }

        return $this->json($post);
    }

    #[Route('/posts', name: 'post_add', methods: 'POST')]
    public function postAdd(Request $request): Response
    {
        $data = Json::decode($request->getContent());
        $postRequestDto = $this->postRequestFactory->create($data);

        try {
            $post = $this->postService->createFromRequest($postRequestDto);
        } catch (Exception $e) {
            // @todo - vratit json s chybou
            throw $e;
        }

        return $this->json($post);
    }
}

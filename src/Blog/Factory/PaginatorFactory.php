<?php
declare(strict_types=1);

namespace Blog\Factory;

use Blog\Core\Paginator;
use Symfony\Component\HttpFoundation\Request;

class PaginatorFactory
{
    public function create(Request $request): Paginator
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        return new Paginator($page, $limit);
    }
}

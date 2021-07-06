<?php
declare(strict_types=1);

namespace Blog\Core;

class Paginator
{
    private int $page;
    private int $limit;
    
    public function __construct(?int $page, ?int $limit)
    {
        if ($page === null) {
            $this->page = 1;
        } else {
            $this->page = $page;
        }
        
        if ($limit === null) {
            $this->limit = 10;
        } else {
            $this->limit = $limit;
        }
    }

    public function getPage(): int
    {
        return $this->page;
    }
    
    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->limit * ($this->page - 1);
    }
}
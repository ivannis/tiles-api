<?php

declare(strict_types=1);

namespace Shop\Domain;

use Hyperf\Paginator\LengthAwarePaginator;

interface Repository
{
    /**
     * @return LengthAwarePaginator|Tile[]
     */
    public function findAll(array $criteria, int $page = 1, int $limit = 20): LengthAwarePaginator;
}

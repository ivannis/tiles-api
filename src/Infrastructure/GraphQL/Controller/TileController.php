<?php

declare(strict_types=1);

namespace Shop\Infrastructure\GraphQL\Controller;

use Hyperf\GraphQL\Annotation\Query;
use Hyperf\Paginator\LengthAwarePaginator;
use Shop\Domain\Repository;
use Shop\Domain\Tile;

class TileController
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Query(name="getTiles", outputType="TilePaginator")
     * @return LengthAwarePaginator|Tile[]
     */
    public function findAll(int $page = 1, int $limit = 20): LengthAwarePaginator
    {
        return $this->repository->findAll([], $page, $limit);
    }
}

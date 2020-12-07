<?php

declare(strict_types=1);

namespace Shop\Infrastructure\GraphQL\Type;

use Hyperf\GraphQL\Annotation\Field;
use Hyperf\GraphQL\Annotation\Type;
use Hyperf\Paginator\LengthAwarePaginator;

/**
 * @Type(class=LengthAwarePaginator::class, name="TilePaginator")
 */
class TilePaginatorType
{
    /**
     * @Field(name="items", outputType="[Tile!]!")
     */
    public function getItems(LengthAwarePaginator $paginator): array
    {
        return $paginator->items();
    }

    /**
     * @Field(name="firstItem")
     */
    public function getFirstItem(LengthAwarePaginator $paginator): ?int
    {
        return $paginator->firstItem();
    }

    /**
     * @Field(name="lasItem")
     */
    public function getLasItem(LengthAwarePaginator $paginator): ?int
    {
        return $paginator->lastItem();
    }

    /**
     * @Field(name="hasMorePages")
     */
    public function hasMorePages(LengthAwarePaginator $paginator): bool
    {
        return $paginator->hasMorePages();
    }

    /**
     * @Field(name="perPage")
     */
    public function perPage(LengthAwarePaginator $paginator): int
    {
        return $paginator->perPage();
    }

    /**
     * @Field(name="currentPage")
     */
    public function currentPage(LengthAwarePaginator $paginator): int
    {
        return $paginator->currentPage();
    }

    /**
     * @Field(name="lastPage")
     */
    public function lastPage(LengthAwarePaginator $paginator): int
    {
        return $paginator->lastPage();
    }

    /**
     * @Field(name="count")
     */
    public function count(LengthAwarePaginator $paginator): int
    {
        return $paginator->total();
    }
}

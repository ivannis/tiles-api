<?php

declare(strict_types=1);

namespace Shop\Infrastructure\GraphQL\Type;

use Hyperf\GraphQL\Annotation\SourceField;
use Hyperf\GraphQL\Annotation\Type;
use Shop\Domain\Tile;

/**
 * @Type(class=Tile::class, name="Tile")
 * @SourceField(name="id")
 * @SourceField(name="name")
 * @SourceField(name="url")
 * @SourceField(name="tileImage")
 */
class TileType
{
}

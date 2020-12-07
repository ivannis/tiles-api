<?php

declare(strict_types=1);

namespace Shop\Domain;

class Tile
{
    private string $id;

    private string $name;

    private string $url;

    private string $tileImage;

    public function __construct(string $id, string $name, string $url, string $tileImage)
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->tileImage = $tileImage;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function tileImage(): string
    {
        return $this->tileImage;
    }
}

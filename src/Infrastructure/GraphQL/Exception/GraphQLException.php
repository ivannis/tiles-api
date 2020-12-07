<?php

declare(strict_types=1);

namespace Shop\Infrastructure\GraphQL\Exception;

use Exception;
use GraphQL\Error\ClientAware;

class GraphQLException extends Exception implements ClientAware
{
    private string $category;

    public function __construct(string $message, int $code = 0, string $category)
    {
        parent::__construct($message, $code);

        $this->category = $category;
    }

    public function isClientSafe()
    {
        return true;
    }

    public function getCategory()
    {
        return $this->category;
    }
}

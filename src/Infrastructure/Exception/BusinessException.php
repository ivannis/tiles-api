<?php

declare(strict_types=1);

namespace Shop\Infrastructure\Exception;

use Hyperf\Server\Exception\ServerException;

class BusinessException extends ServerException
{
    private string $reason;

    public function __construct(
        string $message,
        string $reason,
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->reason = $reason;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}

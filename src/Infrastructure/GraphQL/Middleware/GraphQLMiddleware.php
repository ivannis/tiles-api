<?php

declare(strict_types=1);

namespace Shop\Infrastructure\GraphQL\Middleware;

use GraphQL\Error\Error;
use GraphQL\Error\FormattedError;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shop\Infrastructure\Exception\BusinessException;
use Shop\Infrastructure\GraphQL\Exception\GraphQLException;

class GraphQLMiddleware implements MiddlewareInterface
{
    private Schema $schema;

    private bool $debug;

    public function __construct(Schema $schema, bool $debug = false)
    {
        $this->schema = $schema;
        $this->debug = $debug;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (! $this->isGraphQL($request)) {
            return $handler->handle($request);
        }

        $input = $request->getParsedBody();
        $query = $input['query'];
        $variableValues = isset($input['variables']) ? $input['variables'] : null;

        $result = GraphQL::executeQuery($this->schema, $query, null, null, $variableValues)
            ->setErrorFormatter(function (Error $e) {
                $previous = $e->getPrevious();

                if ($previous !== null && $previous instanceof BusinessException) {
                    $e = new Error(
                        $previous->getMessage(),
                        $e->getNodes(),
                        $e->getSource(),
                        $e->getPositions(),
                        $e->getPath(),
                        new GraphQLException($previous->getMessage(), $previous->getCode(), $previous->getReason()),
                        $e->getExtensions()
                    );
                }

                return FormattedError::createFromException($e);
            })
            ->toArray($this->debug);

        return $this->getResponse()->withBody(new SwooleStream(Json::encode($result)));
    }

    protected function getResponse(): ResponseInterface
    {
        return Context::get(ResponseInterface::class);
    }

    protected function isGraphQL(ServerRequestInterface $request): bool
    {
        return $request->getUri()->getPath() === '/graphql';
    }
}

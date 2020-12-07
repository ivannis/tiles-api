<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

/**
 * @method get($uri, $data = [], $headers = [])
 * @method post($uri, $data = [], $headers = [])
 * @method json($uri, $data = [], $headers = [])
 * @method file($uri, $data = [], $headers = [])
 * @method request($method, $path, $options = [])
 */
trait GraphQLClient
{
    private array $response;

    public function printLastResponse()
    {
        echo json_encode($this->response, JSON_PRETTY_PRINT);
    }

    /**
     * Sends a GraphQL query.
     */
    private function iSendAGraphQLQuery(string $query, array $variables = [], string $operation = null)
    {
        $this->response = $this->json('/graphql', [
            'query' => $query,
            'variables' => $variables,
            'operationName' => $operation,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Shop\Infrastructure\Repository;

use GuzzleHttp\Client;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Paginator\LengthAwarePaginator;
use Shop\Domain\Repository;
use Shop\Domain\Tile;
use Shop\Infrastructure\Exception\BusinessException;

class TileRepository implements Repository
{
    private Client $client;

    public function __construct(string $baseUrl, ClientFactory $factory)
    {
        $this->client = $factory->create([
            'base_uri' => $baseUrl,
            'http_errors' => false,
        ]);
    }

    /**
     * @return array|Tile[]
     */
    public function findAll(array $criteria, int $page = 1, int $limit = 20): LengthAwarePaginator
    {
        $response = $this->client->get('tiles', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'page' => [
                    'size' => $limit,
                    'number' => $page,
                ],
                'include' => 'activePromotion',
                'filter' => [
                    'order' => 'Offers & Deals',
                    'category_id' => '1',
                ],
            ],
        ]);

        $result = json_decode((string) $response->getBody(), true);
        if ($response->getStatusCode() !== 200) {
            $error = $result['errors'][0] ?? [
                'message' => 'Internal server error',
                'code' => 'BAD_REQUEST',
                'status' => 500,
            ];

            throw new BusinessException($error['message'], $error['code'], $error['status']);
        }

        return new LengthAwarePaginator(
            $this->mapItems($result['data']),
            $result['meta']['count'],
            $limit,
            $page,
        );
    }

    private function mapItems(array $items): array
    {
        return array_map(
            fn (array $item) => new Tile(
                $item['id'],
                $item['attributes']['name'],
                $item['attributes']['url'],
                $item['attributes']['tileImage']['url']
            ),
            $items
        );
    }
}

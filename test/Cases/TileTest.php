<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

use HyperfTest\HttpTestCase;

/**
 * @internal
 * @coversNothing
 */
class TileTest extends HttpTestCase
{
    use GraphQLClient;

    public function testDefaultTilesQuery()
    {
        $query = <<< 'GQL'
query {
  getTiles {
    items {
      id
      name
    }
    firstItem
    lasItem
    hasMorePages
    perPage
    currentPage
    lastPage
    count
  }
}
GQL;
        $this->iSendAGraphQLQuery($query);

        $this->assertArrayHasKey('data', $this->response);
        $this->assertArrayHasKey('getTiles', $this->response['data']);
        $this->assertArrayHasKey('items', $this->response['data']['getTiles']);
        $this->assertArrayHasKey('firstItem', $this->response['data']['getTiles']);
        $this->assertArrayHasKey('lasItem', $this->response['data']['getTiles']);
        $this->assertArrayHasKey('firstItem', $this->response['data']['getTiles']);
        $this->assertArrayHasKey('hasMorePages', $this->response['data']['getTiles']);
        $this->assertArrayHasKey('perPage', $this->response['data']['getTiles']);
        $this->assertArrayHasKey('currentPage', $this->response['data']['getTiles']);
        $this->assertArrayHasKey('lastPage', $this->response['data']['getTiles']);
        $this->assertArrayHasKey('count', $this->response['data']['getTiles']);

        $this->assertCount(20, $this->response['data']['getTiles']['items']);
        foreach ($this->response['data']['getTiles']['items'] as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('name', $item);
            $this->assertArrayNotHasKey('url', $item);
            $this->assertArrayNotHasKey('tileImage', $item);
        }

        $this->assertEquals(1, $this->response['data']['getTiles']['firstItem']);
        $this->assertEquals(20, $this->response['data']['getTiles']['lasItem']);
        $this->assertTrue($this->response['data']['getTiles']['hasMorePages']);
        $this->assertEquals(20, $this->response['data']['getTiles']['perPage']);
        $this->assertEquals(1, $this->response['data']['getTiles']['currentPage']);
        $this->assertIsInt($this->response['data']['getTiles']['lastPage']);
        $this->assertIsInt($this->response['data']['getTiles']['count']);
    }

    public function testTilesQueryWithCustomPageLimits()
    {
        $query = <<< 'GQL'
query {
  getTiles(page: 1, limit: 8) {
    items {
      id
      name
      url
      tileImage
    }
    firstItem
    lasItem
    hasMorePages
    perPage
    currentPage
    lastPage
    count
  }
}
GQL;
        $this->iSendAGraphQLQuery($query);

        $this->assertEquals(1, $this->response['data']['getTiles']['firstItem']);
        $this->assertEquals(8, $this->response['data']['getTiles']['lasItem']);
        foreach ($this->response['data']['getTiles']['items'] as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('name', $item);
            $this->assertArrayHasKey('url', $item);
            $this->assertArrayHasKey('tileImage', $item);
        }

        $page = $this->response['data']['getTiles']['lastPage'];
        $query = <<< GQL
query {
  getTiles(page: {$page}, limit: 8) {
    items {
      id      
    }
    hasMorePages
  }
}
GQL;
        $this->iSendAGraphQLQuery($query);
        $this->assertFalse($this->response['data']['getTiles']['hasMorePages']);
    }
}

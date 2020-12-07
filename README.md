# Introduction

Implement a simple GraphQL server which implements a single getTiles query.

This query should resolve to the current shop directory API end point `https://shop-directory-heroku.laybuy.com/api/tiles?page%5Bsize%5D=8&page%5Bnumber%5D=1&include=activePromotion&filter%5Border%5D=Offers%20%26%20Deals&filter%5Bcategory_id%5D=1` which returns a collection of merhchant tiles. Ideally most of the key attributes should be mapped to the GrapqQL schema.

This is a sample of the getTiles GraphQL query.

```
{
    getTiles{
        id
        name
        url
        tileImage
    } 
}
```

# Requirements

If you don't want to use Docker as the basis for your running environment, you need to make sure that your operating environment meets the following requirements:
   
- PHP >= 7.4
- Composer >= 2.0.2
- Swoole PHP extension >= 4.4，and Disabled `Short Name`
- JSON PHP extension
 
# Installation

Execute the following command to create a copy of the `tiles-api` project.

```
git clone git@github.com:ivannis/tiles-api.git
cd tiles-api
cp .env.example .env
docker-compose build
```


# Usage

Once installed, you can run the following commands to start server:

```
docker-compose up -d
docker exec -it tiles-api bash
php bin/hyperf.php start
# press CTRL + C to terminate the current process
```

Download one of the graphQL clients:
- [Altair](https://altair.sirmuel.design)
- [Graphql playground](https://github.com/prisma-labs/graphql-playground)
- [GraphiQL](https://github.com/graphql/graphiql)

Now you can use API at the endpoint: `http://0.0.0.0:9501/graphql`.

> Example query:
```

query{
  getTiles (page:2, limit: 10){
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
```

# Tests

```
$ composer test
```

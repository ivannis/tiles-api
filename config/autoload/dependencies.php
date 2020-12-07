<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Cache\Adapter\Filesystem\FilesystemCachePool;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Guzzle\ClientFactory;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;
use Shop\Domain\Repository;
use Shop\Infrastructure\Repository\TileRepository;

return [
    Repository::class => function (ContainerInterface $container) {
        $config = $container->get(ConfigInterface::class);

        return new TileRepository($config->get('api_url'), $container->get(ClientFactory::class));
    },
    CacheInterface::class => function () {
        $filesystemAdapter = new Local(__DIR__ . '/../../runtime');
        $filesystem = new Filesystem($filesystemAdapter);

        return new FilesystemCachePool($filesystem);
    },
];

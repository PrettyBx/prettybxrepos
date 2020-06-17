<?php

declare(strict_types=1);

namespace PrettyBx\Repositories;

use PrettyBx\Support\Contracts\ServiceProviderContract;
use Prozorov\Repositories\RepositoryFactory;
use Prozorov\Repositories\Resolvers\ContainerAwareResolver;

abstract class RepositoryServiceProvider implements ServiceProviderContract
{
    /**
     * @var array $repositories
     */
    protected $repositories = [];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        container()->singleton(RepositoryFactory::class, function () {
            return new RepositoryFactory(
                new ContainerAwareResolver(container()),
                $this->repositories,
                FixtureResolver::class
            );
        });
    }
}

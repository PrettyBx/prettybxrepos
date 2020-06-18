<?php

declare(strict_types=1);

namespace PrettyBx\Repositories\Resolvers;

use Prozorov\Repositories\Contracts\{RepositoryInterface, ResolverInterface};
use PrettyBx\Repositories\Repositories\IblockRepository;
use Prozorov\Repositories\Exceptions\CouldNotResolve;

class IblockResolver implements ResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolve(string $className): RepositoryInterface
    {
        if (! preg_match('/^(iblock_)(\d+)/', $className, $matches)) {
            throw new CouldNotResolve();
        }

        if ((int) $matches[2] <= 0) {
            throw new CouldNotResolve();
        }

        return new IblockRepository((int) $matches[2]);
    }
}

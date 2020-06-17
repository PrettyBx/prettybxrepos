<?php

declare(strict_types=1);

namespace PrettyBx\Repositories;

use Prozorov\Repositories\Contracts\FixtureResolverInterface;
use Prozorov\Repositories\ArrayRepository;

class FixtureResolver implements FixtureResolverInterface
{
    /**
     * @var int $number
     */
    protected $number;

    public function __construct(int $number = 5)
    {
        $this->number = $number;
    }

    /**
     * @inheritDoc
     */
    public function getFixtures($fixtures): ArrayRepository
    {
        if (is_array($fixtures)) {
            return new ArrayRepository($fixtures);
        }

        if (is_string($fixtures)) {
            return new ArrayRepository(fixture()->makeMany($fixtures, $this->number));
        }

        throw new \InvalidArgumentException('Unable to resolve fixture');
    }
}

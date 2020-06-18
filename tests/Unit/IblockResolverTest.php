<?php

namespace Prozorov\Repositories\Tests;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Prozorov\Repositories\RepositoryFactory;
use PrettyBx\Repositories\Resolvers\IblockResolver;
use PrettyBx\Repositories\Repositories\IblockRepository;
use Prozorov\Repositories\Exceptions\CouldNotResolve;

class IblockResolverTest extends MockeryTestCase
{
    /**
     * @var RepositoryFactory $factory
     */
    protected $factory;

    public function setUp(): void
    {
        $this->factory = new RepositoryFactory(new IblockResolver(), []);
    }

    /**
     * @test
     */
    public function iblock_id_is_set()
    {
        $this->prepareLoader();

        $repo = $this->factory->getRepository('iblock_17');

        $this->assertEquals(17, $repo->getIblockId());
    }

    /**
     * @test
     */
    public function exception_is_thrown()
    {
        $this->expectException(CouldNotResolve::class);

        $repo = $this->factory->getRepository('iblock_non-existent');
    }

    /**
     * Prepares Bitrix loader
     *
     * @access	protected
     * @return	void
     */
    protected function prepareLoader(): void
    {
        $loader = $this->getMockBuilder('\Bitrix\Main\Loader')
            ->setMethods(['includeModule'])
            ->getMock();

        $loader->expects($this->once())
            ->method('includeModule')
            ->with($this->equalTo('iblock'))
            ->willReturn(true);

        container()->bind('\Bitrix\Main\Loader', function () use ($loader) {
            return $loader;
        });
    }
}

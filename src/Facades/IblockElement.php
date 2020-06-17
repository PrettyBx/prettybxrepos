<?php

declare(strict_types=1);

namespace PrettyBx\Repositories\Facades;

use PrettyBx\Support\Base\AbstractFacade;

class IblockElement extends AbstractFacade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return '\CIBlockElement';
    }
}

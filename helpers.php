<?php

if (! function_exists('repository')) {
    function repository($code) {
        return container()->make(\Prozorov\Repositories\RepositoryFactory::class)->getRepository($code);
    }
}

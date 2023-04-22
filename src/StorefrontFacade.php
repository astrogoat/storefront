<?php

namespace Astrogoat\Storefront;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Astrogoat\Storefront\Storefront
 */
class StorefrontFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'storefront';
    }
}

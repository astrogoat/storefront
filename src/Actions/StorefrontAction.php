<?php

namespace Astrogoat\Storefront\Actions;

use Helix\Lego\Apps\Actions\Action;

class StorefrontAction extends Action
{
    public static function actionName(): string
    {
        return 'Storefront action name';
    }

    public static function run(): mixed
    {
        return redirect()->back();
    }
}

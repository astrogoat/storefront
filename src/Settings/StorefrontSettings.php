<?php

namespace Astrogoat\Storefront\Settings;

use Astrogoat\Storefront\Actions\StorefrontAction;
use Helix\Lego\Settings\AppSettings;
use Illuminate\Validation\Rule;

class StorefrontSettings extends AppSettings
{
    // public string $url;

    public function rules(): array
    {
        return [
            // 'url' => Rule::requiredIf($this->enabled === true),
        ];
    }

    // protected static array $actions = [
    //     StorefrontAction::class,
    // ];

    // public static function encrypted(): array
    // {
    //     return ['access_token'];
    // }

    public function description(): string
    {
        return 'Interact with Storefront.';
    }

    public static function group(): string
    {
        return 'storefront';
    }
}

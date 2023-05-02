<?php

namespace Astrogoat\Storefront;

use Astrogoat\Storefront\Http\Livewire\StorefrontOrderCreateForm;
use Astrogoat\Storefront\Http\Livewire\StorefrontOrderForm;
use Astrogoat\Storefront\Http\Livewire\StorefrontOrderIndex;
use Astrogoat\Storefront\Http\Livewire\StorefrontProductForm;
use Astrogoat\Storefront\Http\Livewire\StorefrontProductIndex;
use Astrogoat\Storefront\Http\Livewire\StorefrontCollectionForm;
use Astrogoat\Storefront\Http\Livewire\StorefrontCollectionIndex;
use Astrogoat\Storefront\Http\Livewire\StorefrontSaleForm;
use Astrogoat\Storefront\Http\Livewire\StorefrontSaleIndex;
use Astrogoat\Storefront\Models\Collection;
use Astrogoat\Storefront\Models\Product;
use Astrogoat\Storefront\Models\StoreOrder;
use Helix\Fabrick\Icon;
use Helix\Lego\Apps\App;
use Helix\Lego\LegoManager;
use Helix\Lego\Menus\Lego\Group;
use Helix\Lego\Menus\Lego\Link;
use Helix\Lego\Menus\Menu;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Astrogoat\Storefront\Settings\StorefrontSettings;

class StorefrontServiceProvider extends PackageServiceProvider
{
    public function registerApp(App $app)
    {
        return $app
            ->name('storefront')
            ->settings(StorefrontSettings::class)
            ->migrations([
                __DIR__ . '/../database/migrations',
                __DIR__ . '/../database/migrations/settings',
            ])
            ->models([
                Product::class,
                Collection::class,
                StoreOrder::class,
            ])
            ->menu(function (Menu $menu) {
                $menu->addToSection(
                    Menu::MAIN_SECTIONS['PRIMARY'],
                    Group::add(
                        'Storefront',
                        [
                            Link::to(route('lego.storefront.products.index'), 'Products'),
                            Link::to(route('lego.storefront.collections.index'), 'Collections'),
                            Link::to(route('lego.storefront.orders.index'), 'Orders'),
                            Link::to(route('lego.storefront.sales.index'), 'Sales'),
                        ],
                        Icon::TRUCK,
                    )->after('Pages'),
                );
            })
            ->backendRoutes(__DIR__.'/../routes/backend.php')
            ->frontendRoutes(__DIR__.'/../routes/frontend.php');
    }

    public function registeringPackage()
    {
        $this->callAfterResolving('lego', function (LegoManager $lego) {
            $lego->registerApp(fn (App $app) => $this->registerApp($app));
        });
    }

    public function configurePackage(Package $package): void
    {
        $package->name('storefront')->hasConfigFile()->hasViews();
    }

    public function bootingPackage()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../public' => public_path('vendor/storefront'),
            ], 'storefront-assets');
        }

        Livewire::component('astrogoat.storefront.http.livewire.storefront-collection-index', StorefrontCollectionIndex::class);
        Livewire::component('astrogoat.storefront.http.livewire.storefront-collection-form', StorefrontCollectionForm::class);
        Livewire::component('astrogoat.storefront.http.livewire.storefront-product-index', StorefrontProductIndex::class);
        Livewire::component('astrogoat.storefront.http.livewire.storefront-product-form', StorefrontProductForm::class);
        Livewire::component('astrogoat.storefront.http.livewire.storefront-order-index', StorefrontOrderIndex::class);
        Livewire::component('astrogoat.storefront.http.livewire.storefront-order-form', StorefrontOrderForm::class);
        Livewire::component('astrogoat.storefront.http.livewire.storefront-order-create', StorefrontOrderCreateForm::class);

        Livewire::component('astrogoat.storefront.http.livewire.storefront-sale-index', StorefrontSaleIndex::class);
        Livewire::component('astrogoat.storefront.http.livewire.storefront-sale-form', StorefrontSaleForm::class);

    }
}

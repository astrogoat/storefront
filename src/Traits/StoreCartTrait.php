<?php

namespace Astrogoat\Storefront\Traits;

use Astrogoat\Storefront\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait StoreCartTrait
{
    protected Collection $content;
    protected String $cartKey = 'store_cart';

    public function initializeCart(): void
    {
        $this->content = Cache::has($this->cartKey) ? Cache::get($this->cartKey) : $this->getEmptyCart();
    }

    public function getSubTotal(): float
    {
        $total = $this->getItems()->sum('price');

        return $total;
    }

    public function getTotal(): float
    {
        $total = $this->getItems()->sum('price');

        return $total;
    }

    public function getItems()
    {
        return $this->getContent()['items'];
    }

    public function getContent(): Collection
    {
        return Cache::has($this->cartKey) ? Cache::get($this->cartKey) : $this->getEmptyCart();
    }

    protected function getEmptyCart(): Collection
    {
        $emptyCart = collect([
            'items' => new Collection(),
//            'discounts' => new Collection(),
//            'presentmentCurrencyCode' => $this->settings->currency,
        ]);

        Cache::put($this->cartKey, $emptyCart);

        return $emptyCart;
    }

    public function add(Product $product, int $quantity = 1, array $properties = []): void
    {
        $updatedCartItems = $this->getItems()->put($product->id, $product);
        $updatedContent = $this->getContent()->put('items', $updatedCartItems);

        //        $this->clearCache();
        $this->saveCart($updatedContent);

        // Redirect to  cart page
        if(method_exists(__CLASS__, 'redirectToCart')) {
            $this->redirectToCart();
        }
    }

    public function removeFromCart(Product $itemToRemove): void
    {
        $updatedCartItems = $this->getItems()->reject(fn (Product $item) => $item->id === $itemToRemove->id);
        $updatedContent = $this->getContent()->put('items', $updatedCartItems);

        $this->clearCache();

        $this->saveCart($updatedContent);
    }

    public function clearCache(): void
    {
        Cache::delete($this->cartKey);
        $this->initializeCart();
    }

    public function saveCart($content): void
    {
        Cache::put($this->cartKey, $content);
    }
}

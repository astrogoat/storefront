<?php

namespace Astrogoat\Storefront\Http\Controllers;

use Astrogoat\Storefront\Models\Product;
use Helix\Lego\Events\PageViewed;

class StorefrontProductController
{
    public function index()
    {
        $products = Product::paginate(20);

        return view('storefront::models.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('sections');

        event(new PageViewed(
            type: 'product',
            attributes: [
                'class' => $product::class,
                'id' => $product->id,
            ]
        ));

        return view('lego::sectionables.show', ['sectionable' => $product]);
    }

    public function editor(Product $product, $editorView = 'editor')
    {
        $product->load('sections');

        return view('lego::editor.editor', [
            'sectionable' => $product,
            'editorView' => $editorView,
        ]);
    }
}

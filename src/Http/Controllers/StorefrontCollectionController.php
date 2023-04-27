<?php

namespace Astrogoat\Storefront\Http\Controllers;

use Astrogoat\Storefront\Models\Collection;
use Helix\Lego\Events\PageViewed;

class StorefrontCollectionController
{
    public function index()
    {
        $collections = Collection::paginate(20);

        return view('storefront::models.collections.index', compact('collections'));
    }

    public function show(Collection $collection)
    {
        $collection->load('sections');

        event(new PageViewed(
            type: 'collection',
            attributes: [
                'class' => $collection::class,
                'id' => $collection->id,
            ]
        ));

        return view('lego::sectionables.show', ['sectionable' => $collection]);
    }

    public function editor(Collection $collection, $editorView = 'editor')
    {
        $collection->load('sections');

        return view('lego::editor.editor', [
            'sectionable' => $collection,
            'editorView' => $editorView,
        ]);
    }
}

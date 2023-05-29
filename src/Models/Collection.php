<?php

namespace Astrogoat\Storefront\Models;

use Helix\Fabrick\Icon;
use Helix\Lego\Media\HasMedia;
use Helix\Lego\Media\Mediable;
use Helix\Lego\Media\MediaCollection;
use Helix\Lego\Models\Contracts\Indexable;
use Helix\Lego\Models\Contracts\Metafieldable;
use Helix\Lego\Models\Contracts\Publishable;
use Helix\Lego\Models\Contracts\Searchable;
use Helix\Lego\Models\Contracts\Sectionable;
use Helix\Lego\Models\Model as LegoModel;
use Helix\Lego\Models\Traits\CanBePublished;
use Helix\Lego\Models\Traits\HasFooter;
use Helix\Lego\Models\Traits\HasMetafields;
use Helix\Lego\Models\Traits\HasSections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Collection extends LegoModel implements Sectionable, Mediable, Metafieldable, Indexable, Searchable, Publishable
{
    use HasFactory;
    use HasSections;
    use HasSlug;
    use CanBePublished;
    use HasMedia;
    use HasMetafields;
    use HasFooter;

    protected $table = 'storefront_product_collections';

    protected $guarded = [];

    protected $dates = [
        'published_at',
    ];

    protected $casts = [
        'featured_image' => 'json',
        'meta' => 'json',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'storefront_collection_storefront_product')
            ->withPivot('order')
            ->orderBy('order');
    }

    public static function icon(): string
    {
        return Icon::COLLECTION;
    }

    public function editorShowViewRoute(string $layout = null): string
    {
        return route('lego.storefront.collections.editor', [
            'collection' => $this,
            'editor_view' => 'show',
            'layout' => $layout,
        ]);
    }

    public function getEditorRoute(): string
    {
        return route('lego.storefront.collections.editor', $this);
    }

    public static function getDisplayKeyName(): string
    {
        return 'title';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom($this->getDisplayKeyName())
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getMedia(): array
    {
        return $this->featured_image ?: [];
    }

    public function mediaCollections(): array
    {
        return [
            MediaCollection::name('Featured')->maxFiles(1),
        ];
    }

    public function shouldIndex(): bool
    {
        return $this->indexable;
    }

    public function getIndexedRoute(): string
    {
        return route('collections.show', $this);
    }

    public function getEditRoute(): string
    {
        return route('lego.storefront.collections.edit', $this);
    }

    public static function searchableIcon(): string
    {
        return static::icon();
    }

    public static function searchableIndexRoute(): string
    {
        return route('lego.storefront.collections.index');
    }

    public function scopeGlobalSearch($query, $value)
    {
        return $query->where('title', 'LIKE', '%' . $value . '%');
    }

    public function searchableName(): string
    {
        return $this->title;
    }

    public function searchableDescription(): string
    {
        return Str::limit($this->description ?? '', 60);
    }

    public function searchableRoute(): string
    {
        return route('lego.storefront.collections.edit', $this);
    }

    public function getPublishedRoute(): string
    {
        return route('collections.show', $this);
    }
}

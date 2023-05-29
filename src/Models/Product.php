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
use Helix\Lego\Models\Footer;
use Helix\Lego\Models\Model;
use Helix\Lego\Models\Traits\CanBePublished;
use Helix\Lego\Models\Traits\HasMetafields;
use Helix\Lego\Models\Traits\HasSections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model implements Sectionable, Publishable, Indexable, Searchable, Metafieldable, Mediable
{
    use HasFactory;
    use HasSections;
    use HasSlug;
    use CanBePublished;
    use HasMedia;
    use HasMetafields;

    protected $casts = [
        'featured_image' => 'json',
        'meta' => 'json',
    ];

    protected $table = 'storefront_products';

    protected $guarded = [];

    protected $dates = [
        'published_at',
    ];

    //    public function collections()
    //    {
    //        return $this->belongsToMany(Collection::class, 'storefront_collection_storefront_product');
    //    }

    public function getShowRoute(array $parameters = []): string
    {
        return route('products.show', $this);
    }

    public function getEditRoute(): string
    {
        return route('lego.storefront.products.edit', $this);
    }

    public function getEditorRoute(): string
    {
        return route('lego.storefront.products.editor', $this);
    }

    public function editorShowViewRoute(string $layout = null): string
    {
        return route('lego.storefront.products.editor', [
            'product' => $this,
            'editor_view' => 'show',
            'layout' => $layout,
        ]);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom($this->getDisplayKeyName())
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public static function getDisplayKeyName(): string
    {
        return 'title';
    }

    public function footer()
    {
        return $this->belongsTo(Footer::class);
    }

    public function getMedia(): array
    {
        return $this->featured_image ?: [];
    }

    public function mediaCollections(): array
    {
        return [
            MediaCollection::name('Featured')->maxFiles(5),
            MediaCollection::name('Carousel')->maxFiles(5),
        ];
    }

    public function getPublishedAtKey(): string
    {
        return 'published_at';
    }

    public function getPublishedRoute(): string
    {
        return route('products.show', $this);
    }

    public function getIndexedRoute(): string
    {
        return $this->getPublishedRoute();
    }

    public function shouldIndex(): bool
    {
        return $this->indexable ?: false;
    }

    public static function searchableIcon(): string
    {
        return static::icon();
    }

    public function scopeGlobalSearch($query, $value)
    {
        return $query->where('title', 'LIKE', "%{$value}%");
    }

    public function searchableName(): string
    {
        return $this->title;
    }

    public function searchableDescription(): string
    {
        return $this->meta['description'] ?? $this->slug;
    }

    public function searchableRoute(): string
    {
        return route('lego.storefront.products.edit', $this);
    }

    public static function searchableIndexRoute(): string
    {
        return route('lego.storefront.products.index');
    }

    public static function icon(): string
    {
        return Icon::SHOPPING_BAG;
    }

    public static function metafieldableTypeSlug(): string
    {
        return Str::slug(static::displayName());
    }

    public function getSectionTitleAttribute(): string
    {
        return Arr::get($this->meta ?? null, 'page_title') ?: $this->title;
    }
}

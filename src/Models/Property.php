<?php

namespace Wepa\PropertyCatalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wepa\Core\Http\Traits\Backend\PositionModelTrait;
use Wepa\Core\Http\Traits\SeoModelTrait;
use Wepa\Core\Models\Seo;
use Wepa\PropertyCatalog\Database\Factories\PropertyFactory;
use Wepa\PropertyCatalog\Http\Controllers\Frontend\PropertyController;

/**
 * Wepa\PropertyCatalog\Models\Property
 *
 * @property int $id
 * @property int $seo_id
 * @property int $category_id
 * @property string $name
 * @property string $summary
 * @property string $delivery
 * @property string $video_cover
 * @property string $data_sheet
 * @property string $cover
 * @property string $cover_alt
 * @property int $published
 * @property int $position
 * @property array $images
 * @property array $files
 * @property bool $latest
 * @property bool $new
 * @property bool $airbnb
 * @property bool $sold
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $google_earth
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Wepa\PropertyCatalog\Models\Category|null $category
 * @property-read \Wepa\PropertyCatalog\Models\PropertyTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wepa\PropertyCatalog\Models\PropertyTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Property listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Property notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder|Property translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Property translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereOfferPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property withTranslation()
 *
 * @mixin \Eloquent
 */
class Property extends Model
{
    use HasFactory;
    use PositionModelTrait;
    use SeoModelTrait;
    use Translatable;

    public array $translatedAttributes = ['name', 'summary', 'delivery', 'data_sheet', 'cover_alt'];

    public $translationForeignKey = 'property_id';

    protected $fillable = [
        'seo_id',
        'position',
        'category_id',
        'published',
        'highlighted',
        'cover',
        'video_cover',
        'latest',
        'new',
        'airbnb',
        'sold',
        'address',
        'latitude',
        'longitude',
        'google_earth',
    ];

    protected $table = 'procat_properties';

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class, 'property_id', 'id')->orderBy('position');
    }

    public function files(): HasMany
    {
        return $this->hasMany(PropertyFile::class, 'property_id', 'id')->orderBy('position');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(PropertyPrice::class, 'property_id', 'id')->orderBy('position');
    }

    public function seoDefaultParams(): array
    {
        return [
            'package' => 'property_catalog',
            'controller' => PropertyController::class,
            'action' => 'show',
            'page_type' => 'article',
            'change_freq' => Seo::CHANGE_FREQUENCY_MONTHLY,
            'priority' => '0.8',
            'canonical' => true,
        ];
    }

    public function seoRequestParams(): array
    {
        return [];
    }

    public function seoRouteParams(): array
    {
        return $this->id ? ['property' => $this->id] : [];
    }

    protected static function newFactory()
    {
        return PropertyFactory::new();
    }
}

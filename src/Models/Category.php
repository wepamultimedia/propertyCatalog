<?php

namespace Wepa\PropertyCatalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Wepa\Core\Http\Traits\Backend\PositionModelTrait;
use Wepa\Core\Models\Seo;
use Wepa\PropertyCatalog\Database\Factories\CategoryFactory;
use Wepa\PropertyCatalog\Http\Controllers\Frontend\PropertyController;

/**
 * Wepa\PropertyCatalog\Models\Category
 *
 * @property int $id
 * @property int $seo_id
 * @property int $position
 * @property string $name
 * @property string $description
 * @property int $published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wepa\PropertyCatalog\Models\Property> $properties
 * @property-read int|null $properties_count
 * @property-read \Wepa\PropertyCatalog\Models\CategoryTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wepa\PropertyCatalog\Models\CategoryTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Category listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Category translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTranslation()
 *
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;
    use Translatable;
    use PositionModelTrait;

    public array $translatedAttributes = ['name', 'description'];

    public $translationForeignKey = 'category_id';

    protected $fillable = [
        'seo_id',
        'name',
        'position',
        'published',
    ];

    protected $table = 'procat_categories';

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'category_id', 'id');
    }

    public function seo(): HasOne
    {
        return $this->hasOne(Seo::class, 'id', 'seo_id')
            ->withDefault([
                'controller' => PropertyController::class,
                'action' => 'index',
            ]);
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}

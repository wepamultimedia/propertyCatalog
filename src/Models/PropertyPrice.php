<?php

namespace Wepa\PropertyCatalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wepa\Core\Http\Traits\Backend\PositionModelTrait;
use Wepa\PropertyCatalog\Database\Factories\PropertyImageFactory;


/**
 * Wepa\PropertyCatalog\Models\PropertyPrice
 *
 * @property int $id
 * @property int $property_id
 * @property string $name
 * @property string $price
 * @property int $position
 * @property-read \Wepa\PropertyCatalog\Models\Property|null $property
 * @property-read \Wepa\PropertyCatalog\Models\PropertyPriceTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wepa\PropertyCatalog\Models\PropertyPriceTranslation> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice translated()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyPrice withTranslation()
 * @mixin \Eloquent
 */
class PropertyPrice extends Model
{
    use HasFactory;
    use PositionModelTrait;
    use Translatable;

    protected $table = 'procat_properties_prices';

    public $timestamps = false;

    public array $translatedAttributes = ['name'];

    public $translationForeignKey = 'price_id';

    protected $fillable = [
        'price',
        'property_id',
        'position',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'id', 'property_id');
    }
}

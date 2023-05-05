<?php

namespace Wepa\PropertyCatalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wepa\Core\Http\Traits\Backend\PositionModelTrait;
use Wepa\PropertyCatalog\Database\Factories\PropertyImageFactory;

/**
 * Wepa\PropertyCatalog\Models\PropertyImage
 *
 * @property int $id
 * @property int $property_id
 * @property string $image_url
 * @property string $image_alt
 * @property int $position
 * @property-read \Wepa\PropertyCatalog\Models\Property|null $property
 * @property-read \Wepa\PropertyCatalog\Models\PropertyImageTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wepa\PropertyCatalog\Models\PropertyImageTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Wepa\PropertyCatalog\Database\Factories\PropertyImageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage translated()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyImage withTranslation()
 *
 * @mixin \Eloquent
 */
class PropertyImage extends Model
{
    use HasFactory;
    use PositionModelTrait;
    use Translatable;

    protected $table = 'procat_properties_images';

    public $timestamps = false;

    public array $translatedAttributes = ['image_alt'];

    public $translationForeignKey = 'image_id';

    protected $fillable = [
        'property_id',
        'image_url',
        'position',
    ];

    protected static function newFactory(): PropertyImageFactory
    {
        return PropertyImageFactory::new();
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'id', 'property_id');
    }
}

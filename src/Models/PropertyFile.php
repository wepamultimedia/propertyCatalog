<?php

namespace Wepa\PropertyCatalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wepa\Core\Http\Traits\Backend\PositionModelTrait;

/**
 * Wepa\PropertyCatalog\Models\PropertyFile
 *
 * @property int $id
 * @property int $property_id
 * @property string $file_url
 * @property int $position
 * @property string $name
 * @property-read \Wepa\PropertyCatalog\Models\Property|null $property
 * @property-read \Wepa\PropertyCatalog\Models\PropertyFileTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Wepa\PropertyCatalog\Models\PropertyFileTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile translated()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFile withTranslation()
 *
 * @mixin \Eloquent
 */
class PropertyFile extends Model
{
    use HasFactory;
    use PositionModelTrait;
    use Translatable;

    protected $table = 'procat_properties_files';

    public $timestamps = false;

    public array $translatedAttributes = ['name'];

    public $translationForeignKey = 'file_id';

    protected $fillable = [
        'property_id',
        'file_url',
        'position',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'id', 'property_id');
    }
}

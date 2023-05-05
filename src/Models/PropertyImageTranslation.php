<?php

namespace Wepa\PropertyCatalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wepa\Core\Http\Traits\Backend\PositionModelTrait;


class PropertyImageTranslation extends Model
{
    use HasFactory;
    
    protected $table = 'procat_properties_images_translations';
    
    public $timestamps = false;
    
    protected $fillable = [
        'image_alt',
    ];
}

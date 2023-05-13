<?php

namespace Wepa\PropertyCatalog\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyPriceTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    protected $table = 'procat_properties_prices_translations';
}

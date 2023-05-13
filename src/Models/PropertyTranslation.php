<?php

namespace Wepa\PropertyCatalog\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'summary', 'delivery', 'data_sheet', 'cover_alt'];

    protected $table = 'procat_properties_translations';
}

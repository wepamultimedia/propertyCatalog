<?php

namespace Wepa\PropertyCatalog\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'summary', 'data_sheet', 'cover_alt'];

    protected $table = 'procat_properties_translations';
}

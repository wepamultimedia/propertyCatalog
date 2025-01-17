<?php

namespace Wepa\PropertyCatalog\Models;

use Illuminate\Database\Eloquent\Model;

class TypeTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    protected $table = 'procat_types_translations';
}

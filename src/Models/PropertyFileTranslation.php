<?php

namespace Wepa\PropertyCatalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFileTranslation extends Model
{
    use HasFactory;

    protected $table = 'procat_properties_files_translations';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}

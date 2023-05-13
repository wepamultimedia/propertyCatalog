<?php

namespace Wepa\PropertyCatalog\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Wepa\PropertyCatalog\Http\Resources\PropertyResource;
use Wepa\PropertyCatalog\Models\Property;

class PropertyController extends Controller
{
    public function highlights(): AnonymousResourceCollection
    {
        return PropertyResource::collection(
            Property::where('highlighted', true)
                ->where('published', true)
                ->orderBy('position', 'desc')
                ->get());
    }

    public function index(): AnonymousResourceCollection
    {
        return PropertyResource::collection(
            Property::orderBy('position', 'desc')
                ->where('published', true)
                ->get());
    }
}

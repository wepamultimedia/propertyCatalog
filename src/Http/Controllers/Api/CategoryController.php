<?php

namespace Wepa\PropertyCatalog\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Wepa\PropertyCatalog\Http\Resources\CategoryResource;
use Wepa\PropertyCatalog\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(string $locale = null)
    {
        if ($locale) {
            app()->setLocale($locale);
        }
        return CategoryResource::collection(Category::orderBy('position')
            ->where('published', true)
            ->get());
    }
}

<?php

namespace Wepa\PropertyCatalog\Http\Controllers\Frontend;


use Cookie;
use Illuminate\Http\Request;
use Inertia\Response;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Wepa\Core\Http\Controllers\Frontend\InertiaController;
use Wepa\PropertyCatalog\Http\Resources\CategoryResource;
use Wepa\PropertyCatalog\Http\Resources\PropertyResource;
use Wepa\PropertyCatalog\Models\Category;
use Wepa\PropertyCatalog\Models\Property;


class PropertyController extends InertiaController
{
    public string $packageName = 'property-catalog';
    
    public function index(Request $request): Response
    {
        $properties = Property::where('published', true)
            ->when($request->category_id, function ($query, $category_id) {
                $query->where('category_id', $category_id);
            })
            ->when($request->search, function ($query, $search) {
                $query->whereTranslationLike('name', "%$search%");
            })
            ->orderBy('position', 'desc')
            ->paginate();
        
        $properties = PropertyResource::collection($properties);
        $category = null;
        
        if ($request->exists('category_id')) {
            $category = CategoryResource::make(Category::find($request->category_id));
        }
        
        $categories = CategoryResource::collection(Category::orderBy('position')
            ->where('published', true)
            ->get());
        
        return $this->render('Vendor/PropertyCatalog/Frontend/Property/Index', ['category', 'property'],
            compact(['properties', 'categories', 'category']));
    }
    
    /**
     * @param  Property  $property
     *
     * @return Response
     */
    public function show(Property $property): Response
    {
        $categories = CategoryResource::collection(Category::orderBy('position')
            ->where('published', true)
            ->get());
        
        $property = PropertyResource::make($property);
        
        return $this->render('Vendor/PropertyCatalog/Frontend/Property/Show', ['category', 'property'],
            compact(['property', 'categories']));
    }
}

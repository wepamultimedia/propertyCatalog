<?php

namespace Wepa\PropertyCatalog\Http\Controllers\Frontend;


use Illuminate\Http\Request;
use Inertia\Response;
use Wepa\Core\Http\Controllers\Frontend\InertiaController;
use Wepa\PropertyCatalog\Http\Requests\PropertyRequest;
use Wepa\PropertyCatalog\Http\Resources\CategoryResource;
use Wepa\PropertyCatalog\Http\Resources\PropertyResource;
use Wepa\PropertyCatalog\Models\Category;
use Wepa\PropertyCatalog\Models\Property;


class PropertyController extends InertiaController
{
    public string $packageName = 'property-catalog';
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    
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
        
        if($request->exists('category_id')){
            $category = CategoryResource::make(Category::find($request->category_id));
        }
        
        $categories = CategoryResource::collection(Category::orderBy('position')
            ->where('published', true)
            ->get());
        
        return $this->render('Vendor/PropertyCatalog/Frontend/Property/Index', ['category', 'property'],
            compact(['properties', 'categories', 'category']));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {
        //
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyRequest $request, $id)
    {
        //
    }
}

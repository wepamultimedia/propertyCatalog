<?php

namespace Wepa\PropertyCatalog\Http\Controllers\Backend;


use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Inertia\Response;
use Wepa\Core\Http\Controllers\Backend\InertiaController;
use Wepa\Core\Http\Traits\Backend\SeoControllerTrait;
use Wepa\Core\Models\Seo;
use Wepa\PropertyCatalog\Http\Requests\PropertyRequest;
use Wepa\PropertyCatalog\Http\Resources\CategoryResource;
use Wepa\PropertyCatalog\Http\Resources\PropertyImageResource;
use Wepa\PropertyCatalog\Http\Resources\PropertyResource;
use Wepa\PropertyCatalog\Models\Category;
use Wepa\PropertyCatalog\Models\Property;
use Wepa\PropertyCatalog\Models\PropertyImage;


class PropertyController extends InertiaController
{
    use SeoControllerTrait;
    
    
    public string $packageName = 'property-catalog';
    
    /**
     * @param $property
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(Property $property): Application|RedirectResponse|Redirector
    {
        Seo::where('id', $property->seo_id)->delete();
        $property->delete();
        
        return redirect(route('admin.property_catalog.properties.index'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Property  $property
     *
     * @return Response
     */
    public function edit(Property $property): Response
    {
        $categories = CategoryResource::collection(Category::all());
        $property = PropertyResource::make($property);
        
        $images = PropertyImageResource::collection($property->images);
        
        return $this->render('Vendor/PropertyCatalog/Backend/Property/Edit', ['core::seo', 'property'], compact(['property', 'categories', 'images']));
    }
    
    /**
     * @param  Request  $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $categories = Category::where('published', true)->get();
        
        $properties = PropertyResource::collection(Property::when($request->search,
            function ($query, $search) {
                $query->whereTranslationLike('name', '%'.$search.'%');
            })
            ->when($request->category_id,
                function ($query, $category_id) {
                    $query->where(['category_id' => $category_id]);
                })
            ->orderBy('position', 'desc')
            ->paginate());
        
        return $this->render('Vendor/PropertyCatalog/Backend/Property/Index', ['property'],
            compact(['categories', 'properties']));
    }
    
    public function position(Property $property, int $position): void
    {
        $property->updatePosition($position);
    }
    
    public function publish(Property $property, bool $published): void
    {
        $property->update(['published' => $published]);
    }
    
    /**
     * @param  PropertyRequest  $request
     * @param  Property  $property
     *
     * @return Redirector|RedirectResponse|Application
     */
    public function update(PropertyRequest $request, Property $property): Redirector|RedirectResponse|Application
    {
        $seoId = $this->seoUpdateOrCreate([
            'route_params' => ['property' => $property->id],
        ]);
        
        $data = collect($request->all())
            ->merge($request->translations)
            ->merge(['seo_id' => $seoId])
            ->except(['translations'])
            ->toArray();
        
        $property->update($data);
        
        return redirect(route('admin.property_catalog.properties.index'));
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
     * @param  PropertyRequest  $request
     *
     * @return Redirector|RedirectResponse|Application
     * @throws BindingResolutionException
     */
    public function store(PropertyRequest $request): Redirector|RedirectResponse|Application
    {
        $seoId = $this->seoUpdateOrCreate();
        
        $data = collect($request->all())
            ->merge([
                'seo_id' => $seoId,
                'position' => Property::nextPosition(),
            ])
            ->merge($request->translations)
            ->except(['translations']);
        
        $property = Property::create($data->toArray());
        
        $this->seoUpdate($seoId, [
            'route_params' => ['property' => $property->id],
        ]);
        
        return redirect(route('admin.property_catalog.properties.index'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $categories = CategoryResource::collection(Category::all());
        $property = PropertyResource::make(new Property());
        
        return $this->render('Vendor/PropertyCatalog/Backend/Property/Create', ['core::seo', 'property'],
            compact(['property', 'categories']));
    }
}

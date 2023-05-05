<?php

namespace Wepa\PropertyCatalog\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Inertia\Response;
use Wepa\Core\Http\Controllers\Backend\InertiaController;
use Wepa\Core\Http\Traits\Backend\SeoControllerTrait;
use Wepa\Core\Models\Seo;
use Wepa\PropertyCatalog\Http\Requests\PropertyImageRequest;
use Wepa\PropertyCatalog\Http\Requests\PropertyRequest;
use Wepa\PropertyCatalog\Http\Resources\CategoryResource;
use Wepa\PropertyCatalog\Http\Resources\PropertyResource;
use Wepa\PropertyCatalog\Models\Category;
use Wepa\PropertyCatalog\Models\Property;
use Wepa\PropertyCatalog\Models\PropertyImage;


class PropertyImageController extends Controller
{
    /**
     * @param  PropertyImage  $image
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(PropertyImage $image): Application|RedirectResponse|Redirector
    {
        $image->delete();
        
        return redirect(route('admin.property_catalog.properties.show', ['property' => $image->property_id]));
    }
    
    public function position(PropertyImage $image, int $position): RedirectResponse|Application|Redirector
    {
        $image->updatePosition($position);
        
        return redirect(route('admin.property_catalog.properties.show', ['property' => $image->property_id]));
    }
    
    public function update(PropertyImageRequest $request, PropertyImage $image): Redirector|RedirectResponse|Application
    {
        $data = collect($request->all())
            ->merge($request->translations)
            ->except(['translations'])
            ->toArray();
        
        $image->update($data);
        
        return redirect(route('admin.property_catalog.properties.show', ['property' => $image->property_id]));
    }
    
    /**
     * @param  PropertyImageRequest  $request
     *
     * @return Redirector|RedirectResponse|Application
     */
    public function store(PropertyImageRequest $request): Redirector|RedirectResponse|Application
    {
        $data = collect($request->all())
            ->merge(['position' => PropertyImage::nextPosition(['property_id' => $request->property_id])])
            ->merge($request->translations)
            ->except(['id'])
            ->except(['translations', 'id'])
            ->toArray();
        
        
        $image = PropertyImage::create($data);
        
        return redirect(route('admin.property_catalog.properties.show', ['property' => $image->property_id]));
    }
}

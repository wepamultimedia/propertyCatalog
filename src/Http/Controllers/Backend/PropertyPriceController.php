<?php

namespace Wepa\PropertyCatalog\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Wepa\PropertyCatalog\Http\Requests\PropertyPriceRequest;
use Wepa\PropertyCatalog\Models\PropertyPrice;


class PropertyPriceController extends Controller
{
    public function destroy(PropertyPrice $price): Application|RedirectResponse|Redirector
    {
        $price->delete();
        
        return redirect(route('admin.property_catalog.properties.show', ['property' => $price->property_id]));
    }
    
    public function position(PropertyPrice $price, int $position): RedirectResponse|Application|Redirector
    {
        $price->updatePosition($position);
        
        return redirect(route('admin.property_catalog.properties.show', ['property' => $price->property_id]));
    }
    
    public function store(PropertyPriceRequest $request): Redirector|RedirectResponse|Application
    {
        $data = collect($request->all())
            ->merge(['position' => PropertyPrice::nextPosition(['property_id' => $request->property_id])])
            ->merge($request->translations)
            ->except(['id'])
            ->except(['translations', 'id'])
            ->toArray();
        
        $price = PropertyPrice::create($data);
        
        return redirect(route('admin.property_catalog.properties.show', ['property' => $price->property_id]));
    }
    
    public function update(PropertyPriceRequest $request, PropertyPrice $price): Redirector|RedirectResponse|Application
    {
        $data = collect($request->all())
            ->merge($request->translations)
            ->except(['translations'])
            ->toArray();
        
        $price->update($data);
        
        return redirect(route('admin.property_catalog.properties.show', ['property' => $price->property_id]));
    }
}

<?php

namespace Wepa\PropertyCatalog\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Wepa\PropertyCatalog\Http\Requests\PropertyImageRequest;
use Wepa\PropertyCatalog\Models\PropertyImage;

class PropertyImageController extends Controller
{
    public function destroy(PropertyImage $image): Application|RedirectResponse|Redirector
    {
        $image->placeInLastPosition(['property_id' => $image->property_id]);
        $image->delete();

        return redirect(route('admin.property_catalog.properties.show', ['property' => $image->property_id]));
    }

    public function position(PropertyImage $image, int $position): RedirectResponse|Application|Redirector
    {
        $image->updatePosition($position, ['property_id' => $image->property_id]);

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

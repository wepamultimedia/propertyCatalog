<?php

namespace Wepa\PropertyCatalog\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Wepa\PropertyCatalog\Http\Requests\PropertyFileRequest;
use Wepa\PropertyCatalog\Models\PropertyFile;

class PropertyFileController extends Controller
{
    public function destroy(PropertyFile $file): Application|RedirectResponse|Redirector
    {
        $file->placeInLastPosition(['property_id' => $file->property_id]);
        $file->delete();

        return redirect(route('admin.property_catalog.properties.show', ['property' => $file->property_id]));
    }

    public function position(PropertyFile $file, int $position): RedirectResponse|Application|Redirector
    {
        $file->updatePosition($position, ['property_id' => $file->property_id]);

        return redirect(route('admin.property_catalog.properties.show', ['property' => $file->property_id]));
    }

    public function update(PropertyFileRequest $request, PropertyFile $file): Redirector|RedirectResponse|Application
    {
        $data = collect($request->all())
            ->merge($request->translations)
            ->except(['translations'])
            ->toArray();

        $file->update($data);

        return redirect(route('admin.property_catalog.properties.show', ['property' => $file->property_id]));
    }

    public function store(PropertyFileRequest $request): Redirector|RedirectResponse|Application
    {
        $data = collect($request->all())
            ->merge(['position' => PropertyFile::nextPosition(['property_id' => $request->property_id])])
            ->merge($request->translations)
            ->except(['id'])
            ->except(['translations', 'id'])
            ->toArray();

        $file = PropertyFile::create($data);

        return redirect(route('admin.property_catalog.properties.show', ['property' => $file->property_id]));
    }
}

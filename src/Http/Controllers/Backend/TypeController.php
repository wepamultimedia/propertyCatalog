<?php

namespace Wepa\PropertyCatalog\Http\Controllers\Backend;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Inertia\Response;
use Wepa\Core\Http\Controllers\Frontend\InertiaController;
use Wepa\PropertyCatalog\Http\Requests\TypeRequest;
use Wepa\PropertyCatalog\Http\Resources\TypeResource;
use Wepa\PropertyCatalog\Models\Type;

class TypeController extends InertiaController
{
    public string $packageName = 'property-catalog';

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type): Redirector|RedirectResponse|Application
    {
        $type->delete();

        return redirect(route('admin.property_catalog.types.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type): Response
    {
        $type = TypeResource::make($type);

        return $this->render('Vendor/PropertyCatalog/Backend/Type/Edit', ['core::seo', 'type'],
            compact(['type']));
    }

    public function index(Request $request): Response
    {
        $types = Type::when($request->search,
            function ($query, $search) {
                $query->whereTranslationLike('name', '%'.$search.'%');
            })
            ->paginate();

        return $this->render('Vendor/PropertyCatalog/Backend/Type/Index', 'type', compact(['types']));
    }

    public function update(TypeRequest $request, Type $type): Redirector|RedirectResponse|Application
    {
        $params = collect($request->all())
            ->merge($request->translations)
            ->except(['translations'])
            ->toArray();

        $type->update($params);

        return redirect(route('admin.property_catalog.types.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @throws BindingResolutionException
     */
    public function store(TypeRequest $request): Redirector|RedirectResponse|Application
    {
        $data = collect($request->all())
            ->merge($request->translations)
            ->except(['translations'])
            ->toArray();

        Type::create($data);

        return redirect(route('admin.property_catalog.types.index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $type = TypeResource::make(new Type);

        return $this->render('Vendor/PropertyCatalog/Backend/Type/Create', ['core::seo', 'type'],
            compact(['type']));
    }
}

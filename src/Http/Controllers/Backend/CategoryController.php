<?php

namespace Wepa\PropertyCatalog\Http\Controllers\Backend;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Inertia\Response;
use Wepa\Core\Http\Controllers\Frontend\InertiaController;
use Wepa\Core\Http\Traits\Backend\SeoControllerTrait;
use Wepa\Core\Models\Seo;
use Wepa\PropertyCatalog\Http\Requests\CategoryRequest;
use Wepa\PropertyCatalog\Http\Resources\CategoryResource;
use Wepa\PropertyCatalog\Models\Category;

class CategoryController extends InertiaController
{
    use SeoControllerTrait;

    public string $packageName = 'property-catalog';

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): Redirector|RedirectResponse|Application
    {
        $category->delete();

        return redirect(route('admin.property_catalog.categories.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): Response
    {
        $category = CategoryResource::make($category);

        return $this->render('Vendor/PropertyCatalog/Backend/Category/Edit', ['core::seo', 'category'],
            compact(['category']));
    }

    public function index(Request $request): Response
    {
        $categories = Category::when($request->search,
            function ($query, $search) {
                $query->whereTranslationLike('name', '%'.$search.'%');
            })
            ->orderBy('position')
            ->paginate();

        return $this->render('Vendor/PropertyCatalog/Backend/Category/Index', 'category', compact(['categories']));
    }

    public function position(Category $category, int $position): void
    {
        $category->updatePosition($position);
    }

    public function published(Category $category, bool $published): void
    {
        $category->update(['published' => $published]);
    }

    /**
     * @throws BindingResolutionException
     */
    public function update(CategoryRequest $request, Category $category): Redirector|RedirectResponse|Application
    {
        $params = collect($request->all())
            ->merge($request->translations)
            ->except(['translations'])
            ->toArray();

        $category->update($params);

        return redirect(route('admin.property_catalog.categories.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @throws BindingResolutionException
     */
    public function store(CategoryRequest $request): Redirector|RedirectResponse|Application
    {
        $data = collect($request->all())
            ->merge([
                'position' => Category::nextPosition(),
                'published' => true,
            ])
            ->merge($request->translations)
            ->except(['translations'])
            ->toArray();

        Category::create($data);

        return redirect(route('admin.property_catalog.categories.index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $category = CategoryResource::make(new Category());

        return $this->render('Vendor/PropertyCatalog/Backend/Category/Create', ['core::seo', 'category'],
            compact(['category']));
    }
}

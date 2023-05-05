<?php

namespace Wepa\PropertyCatalog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->when((bool) $this->id, function () {
                return $this->id;
            }),
            'name' => $this->name,
            'description' => $this->description,
            'published' => $this->published,
            'seo' => $this->seo,
            'translations' => $this->when($request->routeIs('*admin*.edit'), function () {
                return $this->getTranslationsArray();
            }),
        ];
    }
}

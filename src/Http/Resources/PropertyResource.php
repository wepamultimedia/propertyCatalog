<?php

namespace Wepa\PropertyCatalog\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;


class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->when((bool) $this->id, function () {
                return $this->id;
            }),
            'name' => $this->name,
            'price' => $this->price,
            'offer_price' => $this->offer_price,
            'position' => $this->position,
            'published' => $this->published,
            'highlighted' => $this->highlighted,
            'summary' => $this->summary,
            'cover' => $this->cover,
            'cover_alt' => $this->cover_alt,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name ?? null,
            'data_sheet' => $this->when(!$request->routeIs('*property-catalog.index'), function () {
                return $this->data_sheet;
            }),
            'images' => $this->when(!$request->routeIs('*admin*'), function () {
                return PropertyImageResource::collection($this->images);
            }),
            'translations' => $this->when($request->routeIs('*admin*.edit'), function () {
                return $this->getTranslationsArray();
            }),
            'seo' => $this->seo,
        ];
    }
}

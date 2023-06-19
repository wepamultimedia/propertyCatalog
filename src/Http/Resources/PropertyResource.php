<?php

namespace Wepa\PropertyCatalog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
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
            'position' => $this->position,
            'published' => $this->published,
            'highlighted' => $this->highlighted,
            'latest' => $this->latest,
            'new' => $this->new,
            'airbnb' => $this->airbnb,
            'summary' => $this->summary,
            'delivery' => $this->delivery,
            'video_cover' => $this->video_cover,
            'cover' => $this->cover,
            'cover_alt' => $this->cover_alt,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name ?? null,
            'data_sheet' => $this->when(! $request->routeIs('*property-catalog.index'), function () {
                return $this->data_sheet;
            }),
            'images' => $this->when(! $request->routeIs('*admin*'), function () {
                return PropertyImageResource::collection($this->images);
            }),
            'files' => $this->files,
            'prices' => $this->prices,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'translations' => $this->when($request->routeIs('*admin*.edit'), function () {
                return $this->getTranslationsArray();
            }),
            'seo' => $this->seo,
        ];
    }
}

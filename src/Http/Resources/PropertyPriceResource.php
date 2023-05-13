<?php

namespace Wepa\PropertyCatalog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyPriceResource extends JsonResource
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
            'property_id' => $this->property_id,
            'name' => $this->name,
            'price' => $this->price,
            'position' => $this->position,
            'translations' => $this->when($request->routeIs('*admin*.edit'), function () {
                return $this->getTranslationsArray();
            }),
        ];
    }
}

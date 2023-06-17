<?php

namespace Wepa\PropertyCatalog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyFileResource extends JsonResource
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
            'file_url' => $this->file_url,
            'name' => $this->name,
            'position' => $this->position,
            'translations' => $this->when($request->routeIs('*admin*.edit'), function () {
                return $this->getTranslationsArray();
            }),
        ];
    }
}

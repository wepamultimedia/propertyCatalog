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
            'type_id' => $this->type_id,
            'type' => $this->when($this->type_id, function () {
                return TypeResource::make($this->type);
            }),
            'name' => $this->name,
            'label' => $this->when($this->type_id, function () {
                return "{$this->type->name}/{$this->name}";
            }),
            'description' => $this->description,
            'published' => $this->published,
            'seo' => $this->seo,
            'translations' => $this->when($request->routeIs('*admin*'), function () {
                return $this->getTranslationsArray();
            }),
        ];
    }
}

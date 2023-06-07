<?php

namespace Wepa\PropertyCatalog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'published' => 'nullable|boolean',
            'highlighted' => 'nullable|boolean',
            'category_id' => 'required|numeric',
            'cover' => 'required|string',
            'video_cover' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'translations.*.name' => 'required|string',
            'translations.*.summary' => 'required|string',
            'translations.*.delivery' => 'nullable|string',
            'translations.*.data_sheet' => 'required|string',
            'translations.*.cover_alt' => 'required|string',
        ];
    }
}

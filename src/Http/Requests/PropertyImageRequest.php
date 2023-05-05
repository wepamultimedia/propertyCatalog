<?php

namespace Wepa\PropertyCatalog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyImageRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'property_id' => 'required|numeric',
                    'image_url' => 'required|string',
                    'image_alt' => 'required|string',
                ];
            case 'PUT':
                return [
                    'property_id' => 'required|numeric',
                    'image_url' => 'required|string',
                    'translations.*.image_alt' => 'required|string',
                ];
        }
    }
}

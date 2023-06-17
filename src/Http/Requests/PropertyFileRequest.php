<?php

namespace Wepa\PropertyCatalog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyFileRequest extends FormRequest
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
                    'file_url' => 'required|string',
                    'name' => 'required|string',
                ];
            case 'PUT':
                return [
                    'property_id' => 'required|numeric',
                    'file_url' => 'required|string',
                    'translations.*.name' => 'required|string',
                ];
        }
    }
}

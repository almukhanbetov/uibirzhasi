<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'type_id'     => 'nullable|integer',
            'deal_type'   => 'nullable|string',
            'region_id'   => 'nullable|integer',
            'city_id'     => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'rooms'       => 'nullable|integer',
            'area_min'    => 'nullable|integer',
            'area_max'    => 'nullable|integer',
            'price_min'   => 'nullable|integer',
            'price_max'   => 'nullable|integer',
        ];
    }
}

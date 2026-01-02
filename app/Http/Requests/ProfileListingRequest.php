<?php

namespace App\Http\Requests;

use App\Models\Listing;
use Illuminate\Foundation\Http\FormRequest;

class ProfileListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'deal_type' => 'required|in:' . Listing::DEAL_SALE . ',' . Listing::DEAL_BUY,
            'type_id' => 'required|exists:types,id',
            'region_id' => 'required|exists:regions,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'area' => 'nullable|numeric|min:0',
            'rooms' => 'required|integer|min:1',
            'price_base' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:5000',
            'photos' => 'nullable|array|min:1',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:4096',
        ];
    }
    public function messages(): array
    {
        return [
            'type_id.required' => 'Выберите тип недвижимости.',
            'type_id.exists' => 'Указанный тип недвижимости не найден.',

            'region_id.required' => 'Выберите область.',
            'region_id.exists' => 'Выбранная  область не найдена.',

            'city_id.required' => 'Укажите город.',
            'city_id.exists' => 'Указанный город не существует.',

            'district_id.required' => 'Укажите район.',
            'district_id.exists' => 'Указанный район не найден.',

            // 'area.required' => 'Введите площадь объекта.',
            'area.numeric' => 'Площадь должна быть числом.',
            'area.min' => 'Площадь не может быть отрицательной.',

            'rooms.required' => 'Укажите количество комнат.',
            'rooms.integer' => 'Количество комнат должно быть целым числом.',
            'rooms.min' => 'Минимальное количество комнат — 1.',

            'price_base.required' => 'Укажите цену.',
            'price_base.numeric' => 'Цена должна быть числом.',
            'price_base.min' => 'Цена не может быть отрицательной.',

            // 'description.required' => 'Добавьте описание.',
            'description.max' => 'Описание не может превышать 5000 символов.',

            'photos.*.image' => 'Каждый файл должен быть изображением.',
            'photos.*.mimes' => 'Допустимые форматы изображений: jpeg, png, jpg, webp.',
            'photos.*.max' => 'Размер каждого изображения не должен превышать 4 МБ.',
        ];
    }
}

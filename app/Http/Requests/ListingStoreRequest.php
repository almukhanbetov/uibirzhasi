<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deal_type'     => 'required|in:sale,buy',
            'type_id'       => 'required|exists:types,id',
            'region_id'     => 'required|exists:regions,id',
            'city_id'       => 'required|exists:cities,id',
            'district_id'   => 'required|exists:districts,id',
            'area'          => 'nullable|numeric|min:1',
            'rooms'         => 'required|integer|min:1|max:20',
            'price_base'    => 'required|numeric|min:1',
            'description'   => 'nullable|string|max:2000',
            'photos.*'      => 'nullable|mimes:jpg,jpeg,png,webp|max:2048'
        ];
    }
    public function messages(): array
    {
        return [
            // Тип сделки
            'deal_type.required' => 'Выберите тип сделки.',
            'deal_type.in'       => 'Недопустимый тип сделки.',
            // Тип недвижимости
            'type_id.required' => 'Выберите тип недвижимости.',
            'type_id.exists'   => 'Выбранный тип не найден.',
            // Регион/Город/Район
            'region_id.required' => 'Выберите регион.',
            'region_id.exists'   => 'Выбранный регион не найден.',

            'city_id.required' => 'Выберите город.',
            'city_id.exists'   => 'Выбранный город не найден.',

            'district_id.required' => 'Выберите район.',
            'district_id.exists'   => 'Выбранный район не найден.',
            // Характеристики
            // 'area.required' => 'Укажите площадь.',
            'area.numeric'  => 'Площадь должна быть числом.',
            'area.min'      => 'Площадь должна быть больше 0 м².',

            'rooms.required' => 'Укажите количество комнат.',
            'rooms.integer'  => 'Количество комнат должно быть числом.',
            'rooms.min'      => 'Минимум 1 комната.',
            'rooms.max'      => 'Слишком много комнат.',

            'price_base.required' => 'Укажите цену.',
            'price_base.numeric'  => 'Цена должна быть числом.',
            'price_base.min'      => 'Цена должна быть больше 0.',

            // Описание
            'description.string' => 'Описание должно быть текстом.',
            'description.max'    => 'Описание слишком длинное (до 2000 символов).',

            // Фото
            'photos.*.mimes' => 'Фото должно быть в формате JPG, JPEG, PNG или WEBP.',
            'photos.*.max'   => 'Размер фото не должен превышать 2 МБ.',
        ];
    }
}

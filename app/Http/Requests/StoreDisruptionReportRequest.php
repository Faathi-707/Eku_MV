<?php

namespace App\Http\Requests;

use App\Enums\DisruptionCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDisruptionReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The map sends the marked area as a JSON string in a hidden input.
     */
    protected function prepareForValidation(): void
    {
        if (is_string($this->input('geojson'))) {
            $this->merge(['geojson' => json_decode($this->input('geojson'), true)]);
        }
    }

    public function rules(): array
    {
        $publishing = $this->input('intent') === 'publish';

        return [
            'intent' => ['required', Rule::in(['draft', 'publish'])],
            'category' => ['required', Rule::enum(DisruptionCategory::class)],
            'cause' => ['required', 'string', 'max:5000'],
            'clearance_period' => ['required', Rule::in(['24h', '48h', 'week', 'extended'])],
            'clear_by' => ['nullable', 'date'],
            'alternative_routes' => [$publishing ? 'required' : 'nullable', 'string', 'max:5000'],
            'other_info' => ['nullable', 'string', 'max:5000'],
            'affected_area' => ['nullable', 'string', 'max:255'],
            'geojson' => [$publishing ? 'required' : 'nullable', 'array'],
            'geojson.type' => ['required_with:geojson', Rule::in(['Feature'])],
            'geojson.geometry.type' => ['required_with:geojson', Rule::in(['Point', 'Polygon'])],
            'geojson.geometry.coordinates' => ['required_with:geojson', 'array'],
            'geojson.properties.shape' => ['required_with:geojson', Rule::in(['circle', 'polygon'])],
            'geojson.properties.radius' => ['required_if:geojson.properties.shape,circle', 'nullable', 'numeric', 'min:1'],
            'verified' => [$publishing ? 'accepted' : 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'geojson.required' => 'Please mark the affected area on the map before publishing.',
        ];
    }
}

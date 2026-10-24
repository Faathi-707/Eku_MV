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
            'geojson' => ['nullable', 'array'],
            'verified' => [$publishing ? 'accepted' : 'nullable'],
        ];
    }
}

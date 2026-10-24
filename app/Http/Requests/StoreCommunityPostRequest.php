<?php

namespace App\Http\Requests;

use App\Enums\CommunityPostType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommunityPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $photoRequired = CommunityPostType::tryFrom((string) $this->input('type'))?->requiresPhoto() ?? true;

        return [
            'type' => ['required', Rule::enum(CommunityPostType::class)],
            'message' => ['required', 'string', 'max:2000'],
            'location' => ['required', 'string', 'max:255'],
            'photo' => [$photoRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'photo.required' => 'Please attach a photo as proof for hazard and rerouting posts.',
            'photo.uploaded' => 'The photo could not be uploaded. Please use an image under 5 MB.',
            'photo.max' => 'The photo must be under 5 MB.',
        ];
    }
}

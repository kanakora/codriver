<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user ? $user->can('manage content') : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:contents,slug'],
            'description' => ['nullable', 'string'],
            'content_type' => ['required', 'in:text,pdf,video,link'],
            'file_path' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'external_url' => ['nullable', 'url'],
            'content_text' => ['nullable', 'string'],
            'publish_status' => ['required', 'in:draft,published'],
            'scheduled_publish_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
            'archived_at' => ['nullable', 'date'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['exists:categories,id'],
        ];
    }

    /**
     * Get the validation messages for the defined rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A title is required.',
            'title.max' => 'Titles may not be longer than 255 characters.',
            'slug.required' => 'A slug is required.',
            'slug.unique' => 'That slug is already in use.',
            'slug.max' => 'Slugs may not be longer than 255 characters.',
            'content_type.required' => 'Select a content type.',
            'content_type.in' => 'Select a valid content type.',
            'file_path.mimes' => 'Uploaded files must be a PDF.',
            'file_path.max' => 'PDF uploads may not exceed 2MB.',
            'external_url.url' => 'External links must be valid URLs.',
            'publish_status.required' => 'Select a publish status.',
            'publish_status.in' => 'Select a valid publish status.',
            'scheduled_publish_at.date' => 'Scheduled publish must be a valid date.',
            'expires_at.date' => 'Expiration must be a valid date.',
            'archived_at.date' => 'Archive date must be a valid date.',
            'category_ids.array' => 'Categories must be an array.',
            'category_ids.*.exists' => 'Select valid categories.',
        ];
    }
}

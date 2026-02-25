<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRoomStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user ? $user->can('manage classrooms') : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_public' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'prerequisite_collection_id' => ['nullable', 'exists:class_rooms,id'],
            'content_ids' => ['nullable', 'array'],
            'content_ids.*' => ['exists:lessons,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A title is required.',
            'title.max' => 'Titles may not be longer than 255 characters.',
            'is_public.boolean' => 'Visibility must be true or false.',
            'sort_order.integer' => 'Order must be a number.',
            'sort_order.min' => 'Order must be zero or higher.',
            'prerequisite_collection_id.exists' => 'Select a valid prerequisite.',
            'content_ids.array' => 'Lessons must be an array.',
            'content_ids.*.exists' => 'Select valid content items.',
        ];
    }
}

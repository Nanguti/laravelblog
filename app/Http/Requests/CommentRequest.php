<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required_if:method,POST|exists:users,id',
            'post_id' => 'required_if:method,POST|exists:posts,id',
            'text' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User does not exist',
            'post_id.required' => 'Post does not exist.',
            'text.required' => 'The comment is required.',
            
        ];
    }
}

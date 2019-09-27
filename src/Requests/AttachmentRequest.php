<?php

namespace Envant\Attachments\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|file',
            'uuid' => 'required|uuid',
            'model_type' => 'required|string',
            'name' => 'nullable|string|max:255',
        ];
    }
}

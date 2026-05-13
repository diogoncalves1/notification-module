<?php
namespace Modules\Notification\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationKeywordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'keyword'     => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}

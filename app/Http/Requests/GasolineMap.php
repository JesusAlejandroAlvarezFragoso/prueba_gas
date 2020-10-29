<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GasolineMap extends FormRequest
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
			'state'=>'nullable|string|min:1',
			'munic'=>'nullable|string|min:1',
			'sort'=>'nullable|string|min:1'
        ];
    }
}

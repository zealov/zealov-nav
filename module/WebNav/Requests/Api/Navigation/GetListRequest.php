<?php

namespace Module\WebNav\Requests\Api\Navigation;

use Illuminate\Foundation\Http\FormRequest;
use Module\WebNav\Requests\GetListRequest as CommonRequest;

class GetListRequest extends FormRequest
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
        return array_merge((new CommonRequest())->rules(), [
            'parent_id'   => ['nullable', 'integer'],
            'category_id' => ['nullable', 'integer'],
            'offset'      => ['nullable', 'integer'],
            'limit'       => ['nullable', 'integer'],
            'order'       => ['nullable'],
        ]);
    }
}

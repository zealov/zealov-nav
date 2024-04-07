<?php

namespace Module\WebNav\Requests\Api\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name' => ['required', 'string', 'unique:categories', 'between:2,60'],
            'label' => ['required', 'string', 'unique:categories', 'between:2,60','regex:/^[0-9a-zA-Z_]{1,}$/'],
            'parent_id' => ['nullable', 'integer'],
            'published' => ['nullable', 'integer'],
            'image_path' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'sort' => ['nullable', 'integer'],
        ];
    }

    /**
     * 获取验证错误的自定义属性。
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('message.category.name'),
            'label' => __('message.category.label'),
        ];
    }


    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
}

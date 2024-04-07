<?php

namespace Module\WebNav\Requests\Api\Navigation;

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
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'unique:navigations', 'between:2,60'],
            'category_id' => ['nullable', 'integer'],
            'url' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'integer'],
            'published' => ['nullable', 'integer'],
            'target'=> ['nullable', 'string'],
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
            'name' => __('message.navigation.name'),
            'url' => __('message.navigation.label'),
            'parent_id' => __('message.navigation.parent_id'),
            'published' => __('message.navigation.published'),
            'image_path' => __('message.navigation.image_path'),
            'description' => __('message.navigation.description'),
            'sort' => __('message.navigation.sort'),
            'category_id' => __('message.navigation.category_id'),
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

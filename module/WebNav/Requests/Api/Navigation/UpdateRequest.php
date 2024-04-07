<?php

namespace Module\WebNav\Requests\Api\Navigation;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Module\WebNav\Models\Navigation;

class UpdateRequest extends FormRequest
{
    public $navigation;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->navigation = Navigation::find($this->route("id"));
        return $this->navigation ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer',],
            'name' => ['required', 'string', Rule::unique('navigations')->ignore($this->navigation), 'between:2,60'],
            'url' => ['nullable', 'string'],
            'category_id' => ['nullable', 'integer'],
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
}

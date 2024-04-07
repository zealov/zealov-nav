<?php

namespace Module\WebNav\Requests\Api\Category;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Module\WebNav\Models\Category;
use Module\WebNav\Models\Navigation;

class UpdateRequest extends FormRequest
{
    public $category;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->category = Category::find($this->route("id"));
        return $this->category ? true : false;
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
            'name' => ['required', 'string', Rule::unique('categories')->ignore($this->category), 'between:2,60'],
            'label' => ['required', 'string', Rule::unique('categories')->ignore($this->category), 'between:2,60','regex:/^[0-9a-zA-Z_]{1,}$/'],
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
            'parent_id' => __('message.category.parent_id'),
            'published' => __('message.category.published'),
            'image_path' => __('message.category.image_path'),
            'description' => __('message.category.description'),
            'sort' => __('message.category.sort'),
        ];
    }
}

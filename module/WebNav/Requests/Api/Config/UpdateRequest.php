<?php

namespace Module\WebNav\Requests\Api\Config;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Module\WebNav\Models\Config;

class UpdateRequest extends FormRequest
{
    public $info;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->info = Config::find($this->route("id"));
        return $this->info ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'between:2,200'],
            'key' => ['required', 'string', Rule::unique('system_config')->ignore($this->info), 'between:2,200'],
            'group' =>['required', 'string'],
            'type' => ['required', 'string'],
            'value' => ['nullable', 'string'],
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

        ];
    }
}

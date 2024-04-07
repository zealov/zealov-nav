<?php

namespace Zealov\Kernel\Request;

use Zealov\Kernel\Rules\ContinuousCharacter;
use Zealov\Kernel\Rules\Directory\ParentDirectory;
use Zealov\Kernel\Rules\EmojiChar;
use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
            'file' => ['required', 'file'],
            'directory' => [
                'nullable', 'string', 'between:1,60', new EmojiChar, new ParentDirectory, new ContinuousCharacter
            ],
            'name' => ['nullable', 'min:1', 'max:1023'],
            'title' => ['nullable'],
            'thumbnail'=>['nullable'],
            'url'=>['nullable']
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
            'file' => __('message.file.file'),
            'directory' => __('message.file.directory'),
            'name' => __('message.file.name'),
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

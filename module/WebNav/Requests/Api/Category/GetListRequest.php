<?php

namespace Module\WebNav\Requests\Api\Category;

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
            'parent_id' => ['nullable', 'integer'],
            'offset'=>['nullable', 'integer'],
            'limit'=>['nullable', 'integer'],
            'order'=>['nullable'],
        ]);
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function attributes()
    {
        return array_merge((new CommonRequest())->attributes(), [
            'parent_id' => __('message.category.parent_id'),
        ]);
    }
}

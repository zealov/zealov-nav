<?php
/****************************************
 * Created by PhpStorm.
 * Author: 刘奇.
 * QQ: 921491025
 * Date: 2023/4/18.
 * Time: 17:18.
 *****************************************/

namespace Module\WebNav\Api\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Module\WebNav\Models\Config;
use Module\WebNav\Requests\Api\Config\CreateRequest;
use Module\WebNav\Requests\Api\Config\UpdateRequest;
use Zealov\Kernel\Response\ApiCode;

class ConfigController extends Controller
{
    public function store(CreateRequest $request)
    {
        $validated = $request->validated();
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData(Config::create($validated))
            ->withMessage(__('message.common.create.success'))
            ->build();
    }

    public function update($id, UpdateRequest $request)
    {
        $validated = $request->validated();
        $config = Config::find($id);
        $config->update($validated);
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData()
            ->withMessage(__('message.common.update.success'))
            ->build();
    }

    public function index(Request $request)
    {
        $group = $request->get('group');
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData(Config::getList($group))
            ->withMessage(__('message.common.search.success'))
            ->build();
    }

    public function group()
    {
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData(Config::getGroup())
            ->withMessage(__('message.common.search.success'))
            ->build();
    }

    public function show($id)
    {
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData(Config::find($id)->toArray())
            ->withMessage(__('message.common.search.success'))
            ->build();
    }
}

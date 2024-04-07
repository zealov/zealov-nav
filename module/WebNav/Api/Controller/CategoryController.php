<?php
/****************************************
 * Created by PhpStorm.
 * Author: 刘奇.
 * QQ: 921491025
 * Date: 2023/4/6.
 * Time: 15:18.
 *****************************************/

namespace Module\WebNav\Api\Controller;

use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Module\WebNav\Models\Category;
use Module\WebNav\Requests\Api\CateGory\CreateRequest;
use Module\WebNav\Requests\Api\CateGory\GetListRequest;
use Module\WebNav\Requests\Api\CateGory\UpdateRequest;
use Module\WebNav\Requests\Api\CateGory\UpdateSortRequest;
use Zealov\Kernel\Response\ApiCode;

class CategoryController extends Controller
{
    public function store(CreateRequest $request)
    {
        $validated = $request->validated();
        $sort = Category::query()->orderBy('sort','desc')->value('sort');
        $validated['sort'] = $sort+1;
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData(Category::create($validated))
            ->withMessage(__('message.common.create.success'))
            ->build();
    }

    public function index(GetListRequest $request)
    {
        $validated = $request->validated();
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData(Category::getList($validated))
            ->withMessage(__('message.common.search.success'))
            ->build();

    }

    public function show($id)
    {
        $category = Category::find($id)->toArray();
        if ($category) {
            return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)->withHttpCode(ApiCode::HTTP_OK)
                ->withData($category)
                ->withMessage(__('message.common.search.success'))
                ->build();
        }

        return ResponseBuilder::asError(ApiCode::HTTP_BAD_REQUEST)
            ->withHttpCode(ApiCode::HTTP_BAD_REQUEST)
            ->withMessage(__('message.common.search.fail'))
            ->build();
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $resultData = Category::updateSave($validated);
        if ($resultData['result']) {
            return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
                ->withHttpCode(ApiCode::HTTP_OK)
                ->withData()
                ->withMessage(__('message.common.update.success'))
                ->build();
        }

        return ResponseBuilder::asError(ApiCode::HTTP_BAD_REQUEST)
            ->withHttpCode(ApiCode::HTTP_BAD_REQUEST)
            ->withMessage(__('message.common.update.fail'))
            ->build();
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
                ->withHttpCode(ApiCode::HTTP_OK)
                ->withMessage(__('message.common.delete.success'))
                ->build();
        }

        return ResponseBuilder::asError(ApiCode::HTTP_BAD_REQUEST)
            ->withHttpCode(ApiCode::HTTP_BAD_REQUEST)
            ->withMessage(__('message.common.delete.fail'))
            ->build();
    }


    /**
     * 更新排序
     * @param UpdateSortRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateSort(UpdateSortRequest $request)
    {
        $validated = $request->validated();
        foreach ($validated['sortData'] as $item) {
            Category::query()->where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData([])
            ->withMessage(__('message.common.update.success'))
            ->build();
    }
}

<?php

namespace Module\WebNav\Api\Controller;

use App\Http\Controllers\Controller;

use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Zealov\Kernel\Request\UploadRequest;
use Zealov\Kernel\Response\ApiCode;
use Zealov\Kernel\Utils\FileSystem;

class FileSystemController extends Controller
{
    /**
     * 上传文件
     *
     * @param UploadRequest $request
     * @return Response
     */
    public function upload(UploadRequest $request): Response
    {
        $validated = $request->validated();
        $directory = $validated['directory'] ?? 'other';
        $fileSystem = new FileSystem($directory);
        try {
            $file = $request->file('file');
            // 使用客户端的文件名后缀，避免MIME解析超出预期(如mp3)
            if(!$file->getClientOriginalExtension()){
                $ext = $file->extension();
            }else{
                $ext = $file->getClientOriginalExtension();
            }
            if(in_array($ext,['php','php3','php4','php5','phtml','pl','sh','py','html','js','htm','shtml','bash'])){
                logger()->error('【上传文件失败】:' . $file->getError() . ' ' . $file->getErrorMessage());
                return ResponseBuilder::asError(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                    ->withHttpCode(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                    ->withData(['file'=>['不支持的文件格式']])
                    ->withMessage('不支持的文件格式')
                    ->build();
            }
            if (isset($validated['name'])) {
                $path = $fileSystem->putFileAs($request, 'file', $validated['name']);
            } else {
                $path = $fileSystem->putFile($request);
            }
            return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
                ->withHttpCode(ApiCode::HTTP_OK)
                ->withMessage(__('message.common.create.success'))
                ->withData([
                    'path'     => '/storage/' . $path,
                    'realPath' => asset('storage/' . $path)
                ])
                ->build();
        } catch (Throwable $exception) {
            return ResponseBuilder::asError(ApiCode::HTTP_BAD_REQUEST)
                ->withHttpCode(ApiCode::HTTP_BAD_REQUEST)
                ->withMessage($exception->getMessage())
                ->build();
        }
    }


}

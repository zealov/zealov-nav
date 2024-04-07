<?php
/****************************************
 * Created by PhpStorm.
 * Author=> 刘奇.
 * QQ=> 921491025
 * Date=> 2023/3/24.
 * Time=> 16=>03.
 *****************************************/

namespace Zealov\Controllers\Api;

use App\Http\Requests\Admin\Admin\UpdatePasswordRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Zealov\Kernel\Response\ApiCode;
use Zealov\Kernel\Utils\Menu;

class AuthController extends Controller
{
    public function getUserInfo()
    {
        $userInfo = [
            "id"        => 20,
            "name"      => "admin",
            "nick_name" => "张三",
            "status"    => 1,
            "email"     => "claption@qq.com",
            "roles"     => [1]
        ];
        $userInfo = collect(Auth::user())->toArray();
        $userInfo['roles'] = ['admin-none'];
        $userInfo['accessedRoutes'] = require __DIR__ . '/../../Config/AdminMenu.php';
        //获取模块下的菜单
        $userInfo['accessedRoutes'] = collect(array_merge($userInfo['accessedRoutes'], Menu::getMenuList()))->sortBy('sort')->values()->all();;
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData($userInfo)
            ->build();
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException
     * @throws \MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException
     * @throws \MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException
     * @throws \MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException
     * @throws \MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException
     * @throws \MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException
     */
    public function login(Request $request)
    {
        if (!captcha_api_check($request->get('code'), $request->get('captchaKey'),'flat')) {
            return ResponseBuilder::asError(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                ->withHttpCode(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                ->withMessage(__('auth.captchaFailed'))
                ->withData([
                    'code' => [__('auth.captchaFailed')]
                ])
                ->build();
        }
        $validator = $this->validateLogin($request);
        if ($error = $validator->errors()->first()) {
            return ResponseBuilder::asError(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                ->withHttpCode(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                ->withData($validator->errors())
                ->withMessage(__($error))
                ->build();
        }
        $credentials = $request->only($this->username() , 'password');
        if ($token = $this->guard()->attempt($credentials)) {

            return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
                ->withHttpCode(ApiCode::HTTP_OK)
                ->withData($this->respondWithTokenData($token))
                ->build();
        }
        return ResponseBuilder::asError(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
            ->withHttpCode(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
            ->withMessage(__('auth.failed'))
            ->withData([
                $this->username() => [__('auth.failed')]
            ])
            ->build();
    }

    public function refresh(){
        try {
            $token = $this->guard()->refresh();
            return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
                ->withHttpCode(ApiCode::HTTP_OK)
                ->withData($this->respondWithTokenData($token))
                ->build();
        } catch (JWTException $exception) {
            return ResponseBuilder::asError(ApiCode::HTTP_TOKEN_EXPIRED)
                ->withHttpCode(ApiCode::HTTP_TOKEN_EXPIRED)
                ->build();
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function logout(): Response
    {
        $this->guard()->logout();
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData()
            ->build();
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return Guard
     */
    protected function guard(): Guard
    {
        return Auth::guard('admin');
    }
    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return array
     */
    protected function respondWithTokenData(string $token): array
    {
        return [
            'access_token' => $token,
//            'token_type'   => 'bearer',
            'expires_in'   => $this->guard()->factory()->getTTL() * 60
        ];
    }


    protected function validateLogin(Request $request)
    {
        $rules = [
            $this->username() => 'required|string',
            'password'        => 'required|string'
        ];
        $message = [
            $this->username().'.required'               => '请填写姓名',
            'password.required'               => '密码不能为空',
        ];
        return \Validator::make($request->all(), $rules, $message);

    }

    public function username()
    {
        return 'name';
    }

    /**
     * 获取图形验证码
     * @return Response
     */
    public function captcha()
    {
        $data = app('captcha')->create('flat', true);
        return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
            ->withHttpCode(ApiCode::HTTP_OK)
            ->withData($data)
            ->withMessage(__('message.common.search.success'))
            ->build();
    }

    /**
     * 修改密码
     * @return Response
     */
    public function updatePassword(Request $request)
    {
        $validator = $this->validatePassword($request);
        if ($error = $validator->errors()->first()) {
            return ResponseBuilder::asError(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                ->withHttpCode(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                ->withData($validator->errors())
                ->withMessage(__($error))
                ->build();
        }
        $userInfo = Auth::user();
        if ($userInfo->update(['password' => Hash::make($request->get('password')), 'salt' => uniqid()])) {
            return ResponseBuilder::asSuccess(ApiCode::HTTP_OK)
                ->withHttpCode(ApiCode::HTTP_OK)
                ->withData()
                ->withMessage(__('message.common.update.success'))
                ->build();
        }
        return ResponseBuilder::asError(ApiCode::HTTP_BAD_REQUEST)
            ->withHttpCode(ApiCode::HTTP_BAD_REQUEST)
            ->withData()
            ->withMessage(__('message.common.update.fail'))
            ->build();
    }
    protected function validatePassword(Request $request)
    {
        $rules = [
            'password'=>['required','min:6','max:20']
        ];
        $message = [
            'password.required'=> '密码不能为空',
        ];
        return \Validator::make($request->all(), $rules, $message);

    }

}

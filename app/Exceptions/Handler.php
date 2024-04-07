<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Zealov\Exception\ThrowException;
use Zealov\Kernel\Response\ApiCode;

class Handler extends ExceptionHandler
{
    public $logId;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * UnauthorizedHttpException
     *
     * @param Throwable $exception
     * @return bool
     */
    protected function isUnauthorizedHttpException(Throwable $exception): bool
    {
        return $exception instanceof AuthorizationException  ||
            $exception instanceof UnauthorizedHttpException ||
            $exception instanceof AuthenticationException;
    }

    /**
     * UnauthorizedHttpException
     *
     * @param Throwable $exception
     * @return bool
     */
    protected function isThrowExceptionHttpException(Throwable $exception): bool
    {
        return $exception instanceof ThrowException  ;
    }

    /**
     * ValidationException
     *
     * @param Throwable $exception
     * @return bool
     */
    protected function isValidationException(Throwable $exception): bool
    {
        return $exception instanceof ValidationException;
    }

    /**
     * AuthorizationException
     *
     * @param Throwable $exception
     * @return bool
     */
    protected function isAuthorizationException(Throwable $exception): bool
    {
//        return $exception instanceof UnauthorizedException || ($exception instanceof HttpException && $exception->getStatusCode() === ApiCode::HTTP_FORBIDDEN);
        return $exception instanceof HttpException && $exception->getStatusCode() === ApiCode::HTTP_FORBIDDEN;
    }

    /**
     * ThrottleRequestsException
     *
     * @param Throwable $exception
     * @return bool
     */
    protected function isThrottleRequestsException(Throwable $exception): bool
    {
        return $exception instanceof ThrottleRequestsException;
    }

    protected function isNotFoundHttpException(Throwable $exception): bool
    {
        return $exception instanceof NotFoundHttpException;
    }

    protected function isMethodNotAllowedHttpException(Throwable $exception): bool
    {
        return $exception instanceof MethodNotAllowedHttpException;
    }

    protected function isSuspiciousOperationException(Throwable $exception): bool
    {
        return $exception instanceof SuspiciousOperationException;
    }

    protected function isMaintenanceModeException(Throwable $exception): bool
    {
        return $exception instanceof MaintenanceModeException
            || (
                $exception instanceof HttpException &&
                $exception->getStatusCode() === ApiCode::HTTP_SERVICE_UNAVAILABLE
            );
    }

    /**
     * 令牌已过期 无法再刷新
     *
     * @param Throwable $exception
     * @return bool
     */
    protected function isTokenExpiredException(Throwable $exception): bool
    {
        return $exception instanceof TokenExpiredException;
    }

    /**
     * @param Throwable $exception
     */
    protected function exceptionError(Throwable $exception)
    {
        if (!$this->isUnauthorizedHttpException($exception) && !$this->isValidationException($exception) &&
        !$this->isThrottleRequestsException($exception) && !$this->isNotFoundHttpException($exception) &&
        !$this->isAuthorizationException($exception) && !$this->isMethodNotAllowedHttpException($exception) &&
        !$this->isSuspiciousOperationException($exception)  && !$this->isMaintenanceModeException($exception) &&
        !$this->isTokenExpiredException($exception)) {
            try {
//                $log = ExceptionError::create([
//                    'message' => $exception->getMessage(),
//                    'code' => $exception->getCode(),
//                    'file' => $exception->getFile(),
//                    'line' => $exception->getLine(),
//                    'trace' => $exception->getTrace(),
//                    'trace_as_string' => $exception->getTraceAsString(),
//                ]);
//                $this->setLogId($log->getId());
            } catch (Exception $e) {
                Log::error($e);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getLogId()
    {
        return $this->logId;
    }

    /**
     * @param mixed $logId
     */
    public function setLogId($logId): void
    {
        $this->logId = $logId;
    }

    /**
     * 定义默认的环境变量
     *
     * @return array
     */
    protected function context(): array
    {
        return array_merge(parent::context(), [

        ]);
    }

    /**
     * Report or log an exception.
     *
     * @param Throwable $e
     * @return void
     *
     * @throws Exception|Throwable
     */
    public function report(Throwable $e)
    {
        $this->exceptionError($e);

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        if(!$this->isApiRequest($request)){

//
            abort(500);
//            if ($this->isNotifyException($e)) {
//                $message = $this->getOriginalMessage($e);
//                if (!empty($message)) {
//                    session()->flash('error', $message);
//                }
//
//            }
//
//            // Handle pretty exceptions which will show a friendly application-fitting page
//            // Which will include the basic message to point the user roughly to the cause.
//            if ($this->isExceptionType($e, PrettyException::class)  && !config('app.debug')) {
//                $message = $this->getOriginalMessage($e);
//                $code = ($e->getCode() === 0) ? 500 : $e->getCode();
//                return response()->view('errors/' . $code, ['message' => $message], $code);
//            }
//
//            // Handle 404 errors with a loaded session to enable showing user-specific information
//            if ($this->isExceptionType($e, NotFoundHttpException::class)) {
//                return \Route::respondWithRoute('fallback');
//            }

            return parent::render($request, $e);
        }
        App::setLocale($request->header('lang', config('app.locale')));
        if ($this->isUnauthorizedHttpException($e)) {
            return ResponseBuilder::asError(ApiCode::HTTP_UNAUTHORIZED)
                ->withHttpCode(ApiCode::HTTP_UNAUTHORIZED)
                ->withData()
                ->build();
        }
        if ($this->isThrowExceptionHttpException($e)) {
            return ResponseBuilder::asError(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                ->withHttpCode(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                ->withData()
                ->withMessage($e->getMessage())
                ->build();
        }

        if ($this->isTokenExpiredException($e)) {
            return ResponseBuilder::asError(ApiCode::HTTP_TOKEN_EXPIRED)
                ->withHttpCode(ApiCode::HTTP_TOKEN_EXPIRED)
                ->withData()
                ->build();
        }
        if ($this->isValidationException($e)) {
            return ResponseBuilder::asError(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                ->withHttpCode(ApiCode::HTTP_UNPROCESSABLE_ENTITY)
                ->withData($e->errors())
                ->build();
        }
        if ($this->isAuthorizationException($e)) {
            return ResponseBuilder::asError(ApiCode::HTTP_FORBIDDEN)
                ->withHttpCode(ApiCode::HTTP_FORBIDDEN)
                ->withData()
                ->build();
        }
        if ($this->isThrottleRequestsException($e)) {
            return ResponseBuilder::asError(ApiCode::HTTP_TOO_MANY_REQUEST)
                ->withHttpCode(ApiCode::HTTP_TOO_MANY_REQUEST)
                ->withData()
                ->build();
        }
        if ($this->isNotFoundHttpException($e)) {
            return ResponseBuilder::asError(ApiCode::HTTP_NOT_FOUND)
                ->withHttpCode(ApiCode::HTTP_NOT_FOUND)
                ->withData()
                ->build();
        }
        if ($this->isMethodNotAllowedHttpException($e)) {
            return ResponseBuilder::asError(ApiCode::HTTP_METHOD_NOT_ALLOWED)
                ->withHttpCode(ApiCode::HTTP_METHOD_NOT_ALLOWED)
                ->withData()
                ->build();
        }
        if ($this->isMaintenanceModeException($e)) {
            return ResponseBuilder::asError(ApiCode::HTTP_SERVICE_UNAVAILABLE)
                ->withHttpCode(ApiCode::HTTP_SERVICE_UNAVAILABLE)
                ->withData()
                ->build();
        }
        if (App::environment('local')) {
            return parent::render($request, $e);
        }
        return ResponseBuilder::asError(ApiCode::HTTP_INTERNAL_SERVER_ERROR)
            ->withHttpCode(ApiCode::HTTP_INTERNAL_SERVER_ERROR)
            ->withData([
                'errorId' => (string) $this->getLogId()
            ])
            ->build();
    }

    /**
     * Check if the given request is an API request.
     */
    protected function isApiRequest(Request $request): bool
    {
        return strpos($request->path(), 'api/') === 0;
    }

//    public function isNotifyException(Throwable $exception): bool
//    {
//        return $exception instanceof NotifyException;
//    }

    /**
     * Get original exception message.
     */
    protected function getOriginalMessage(Exception $e): string
    {
        do {
            $message = $e->getMessage();
        } while ($e = $e->getPrevious());
        return $message;
    }
}

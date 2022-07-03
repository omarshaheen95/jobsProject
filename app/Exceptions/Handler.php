<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if (request()->is('manager/*') && $request->ajax()) {
            if ($exception instanceof AuthorizationException) {
                return $this->setStatusCode(403)->respondWithError([t($exception->getMessage())]);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return $this->setStatusCode(403)->respondWithError([t('Please check HTTP Request Method. - MethodNotAllowedHttpException')]);
            }

            if ($exception instanceof AuthenticationException) {
                return $this->setStatusCode(401)->respondWithError([t('Unauthenticated')]);
            }

            if ($exception instanceof NotFoundHttpException) {
                return $this->setStatusCode(403)->respondWithError([t('Please check your URL to make sure request is formatted properly. - NotFoundHttpException')]);
            }

            if ($exception instanceof GeneralException) {
                return $this->setStatusCode(403)->respondWithError([t($exception->getMessage())]);
            }

            if ($exception instanceof ModelNotFoundException) {
                return $this->setStatusCode(403)->respondWithError([t('The requested item is not available')]);
            }

            if ($exception instanceof ValidationException) {
                $error = "";
                $allMessages = [];
                if ($exception->validator->fails()) {
                    $messages = $exception->validator->messages()->toArray();
                    foreach($messages as $key => $message){
                        $allMessages[$key] = $message[0];
                    }
                }
                return $this->setStatusCode(422)->respondWithError(t($exception->getMessage()), $allMessages);
            }

            /*
            * Redirect if token mismatch error
            * Usually because user stayed on the same screen too long and their session expired
            */
            if ($exception instanceof UnauthorizedHttpException) {
                switch (get_class($exception->getPrevious())) {
                    case \App\Exceptions\Handler::class:
                        return $this->setStatusCode($exception->getStatusCode())->respondWithError('Token has not been provided.');
                }
            }else{
                return $this->setStatusCode(500)->respondWithError($exception->getMessage());
            }

        }

        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException)
        {
            return redirect()->route('manager.home')->with('message', 'ليس لديك صلاحية للوصول للصفحة المطلوبة')->with('m-class', 'error');
        }

        return parent::render($request, $exception);
    }

    /**
     * get the status code.
     *
     * @return statuscode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * set the status code.
     *
     * @param [type] $statusCode [description]
     *
     * @return statuscode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * respond with error.
     *
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithError($message, $errors = [])
    {
        return $this->respond([
            'success' => false,
            'status' => $this->getStatusCode(),
            'message' => $message,
            'errors' => $errors,
        ]);
    }

    /**
     * Respond.
     *
     * @param array $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if (strpos($request->url(), '/api/') !== false){
            return $this->setStatusCode(401)->respondWithError('يرجى تسجيل الدخول');
        }

        $guard = array_get($exception->guards(), 0);
        if (strpos($request->url(), '/api/') !== false){
            return $this->setStatusCode(401)->respondWithError('يرجى تسجيل الدخول');
        }

        if ($guard == 'manager')
        {
            $login = '/manager/login';
        }else{
            $login = '/';
        }
        return redirect()->guest($login);


    }
}

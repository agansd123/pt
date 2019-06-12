<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;

class Handler extends ExceptionHandler
{
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $fe = FlattenException::create($exception);

        $response = [
            'statusCode' => $fe->getStatusCode(),
            'code' => $fe->getCode(),
        ];

        if (env('APP_DEBUG', config('app.debug', false)) == true)
        {
            //$response['line'] = $exception->getLine();
            //$response['file'] = $exception->getFile();
            $response['message'] = $fe->getMessage();
//            $response['trace'] = $fe->getTrace();
        }
        return response()->json($response, $fe->getStatusCode(), $fe->getHeaders());
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Inertia\Inertia;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  Throwable  $exception
     * @return void
     *
     * @throws Exception|Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param  Throwable  $e
     * @return Response    
     */
    public function render($request, Throwable $e): Response
    {        
        $response = parent::render($request, $e);

        if (! app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [500, 503, 404, 403, 401])) {           
            return Inertia::render('Error/Error', [
                    'status' => $response->getStatusCode(),
                    'title' => trans('error.'.$response->getStatusCode().'.title'),
                    'description' => trans('error.'.$response->getStatusCode().'.description'),
                ])
                ->toResponse($request)
                ->setStatusCode($response->getStatusCode());
        } elseif($request->routeIs('verification.resend') && $response->getStatusCode() === 429) {           
            return back()->with([
                'message' => trans('error.429.description'),
            ]);
        } elseif ($response->getStatusCode() === 419) {
            return back()->with([
                'message' => trans('error.419.description'),
            ]);
        }

        return $response;
    }
}

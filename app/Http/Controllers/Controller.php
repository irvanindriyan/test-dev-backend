<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Application;
use App\Helpers\FunctionHelpers;
use Throwable;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        try {
            return response()->json(
                FunctionHelpers::resSuccess(
                    'API Version 1 Laravel ' . Application::VERSION . ' (PHP ' . PHP_VERSION . ')'
                ), 
                200
            );
        } catch (Throwable $throwable) {
            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }

    public function getDataBaseExample()
    {
        DB::beginTransaction();

        try {
            DB::commit();
        } catch (ValidationException $exception) {
            return response()->json(
                FunctionHelpers::resErrorsValidation(
                    $exception
                ), 
                $exception->status
            );
        } catch (Throwable $throwable) {
            DB::rollback();

            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }
}

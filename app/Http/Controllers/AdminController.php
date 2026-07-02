<?php

namespace App\Http\Controllers;

use App\Support\AdminGuard;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

abstract class AdminController extends Controller
{
    protected function safeAdmin(callable $action, Request $request): mixed
    {
        try {
            return $action();
        } catch (ValidationException|AuthenticationException $e) {
            throw $e;
        } catch (HttpExceptionInterface $e) {
            if ($e->getStatusCode() < 500) {
                throw $e;
            }

            return $this->adminFailureResponse($request, $e);
        } catch (Throwable $e) {
            return $this->adminFailureResponse($request, $e);
        }
    }

    protected function adminFailureResponse(Request $request, Throwable $e): mixed
    {
        AdminGuard::log($e);

        $message = AdminGuard::userMessage();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }

        return redirect()
            ->back()
            ->withInput($request->except('password', '_token', 'otp'))
            ->with('error_message', $message);
    }
}

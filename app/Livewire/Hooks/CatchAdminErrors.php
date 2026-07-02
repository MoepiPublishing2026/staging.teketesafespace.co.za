<?php

namespace App\Livewire\Hooks;

use App\Support\AdminGuard;
use App\Support\AdminRoutes;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Livewire\ComponentHook;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class CatchAdminErrors extends ComponentHook
{
    public function exception($e, $stopPropagation): void
    {
        if ($e instanceof ValidationException) {
            return;
        }

        if ($e instanceof AuthenticationException) {
            return;
        }

        if ($e instanceof HttpExceptionInterface && $e->getStatusCode() < 500) {
            return;
        }

        if (! AdminRoutes::matches(request())) {
            return;
        }

        AdminGuard::log($e);

        $message = AdminGuard::userMessage();
        $this->component->addError('admin', $message);
        $this->component->dispatch('toast', type: 'danger', message: $message);

        $stopPropagation();
    }
}

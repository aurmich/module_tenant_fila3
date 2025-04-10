<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Tenant\Models\Tenant;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        $tenant = Tenant::whereHas('domains', function ($query) use ($host) {
            $query->where('domain', $host);
        })->first();

        if (!$tenant) {
            abort(404);
        }

        $tenant->makeCurrent();

        return $next($request);
    }
} 
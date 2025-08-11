<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminPermissions
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $admin = Auth::guard('web')->user();

        if (!$admin->hasPermission($permission) && !$admin->is_super_admin) {
            abort(403, 'Unauthorized action contact administrator !');
        }

        return $next($request);
    }
}

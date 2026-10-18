<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMateriRoleAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            if ($request->expectsJson()) {
                abort(401, 'Sesi Anda telah berakhir. Silakan login kembali.');
            }

            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        if ($user->isMateriOnly()) {
            $routeName = $request->route()?->getName();

            if ($routeName && (str_starts_with($routeName, 'admin.courses.') || $routeName === 'logout')) {
                return $next($request);
            }

            return redirect()->route('admin.courses.index')
                ->with('error', 'Akun Anda hanya memiliki akses untuk mengelola menu Materi.');
        }

        if (! $user->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}

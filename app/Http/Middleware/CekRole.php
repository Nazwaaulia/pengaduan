<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    // bacanya spread op ...$roles -> CekRole:petugas -> $roles = ['petugas']

    // ...$roles akan mengubah string yg dpisah dengan koma menjadi item array, namanya spread operator
    // in_array untuk mengcek data dalam array
    // request->user()->role akan ambil data user yg login bagian role
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }else {
            return redirect()->back();
        }
    }
}

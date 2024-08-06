<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\PermissionsProvider;
class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$modul){
        if (!PermissionsProvider::has($request,$modul)){
            $e = [
                'message' => 'Anda tidak memiliki akses!'
            ];
            return H_apiResError($e);
        }
        return $next($request);
    }
}

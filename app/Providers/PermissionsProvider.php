<?php

namespace App\Providers;

use App\Models\RolePermissions;
use App\Models\User;
use App\Models\Permissions;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Auth;

class PermissionsProvider extends ServiceProvider
{
    public static function has($request, $permission) {
        $user = Auth::user();
        $permission = Permissions::where('slug','=', $permission)->first();
        $role = null;
        if ($permission && $user) {
            $role = RolePermissions::where('permission_id', $permission->id)->where('role_id', $user->role_id)->first();
        }

        $res = !empty($role) || $role != null ? true : false;
        return $res;
    }
}

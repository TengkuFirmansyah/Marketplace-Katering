<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $models = array(
            "Url",
            "Accounts",
            "Permissions",
            "Roles",
            "RolePermissions",
            "RoleMenus",
            "Merchant",
            "MerchantMenu",
            "Orders",
        );

        foreach ($models as $model) {
            $this->app->bind("App\Repositories\\{$model}Repository", "App\Repositories\\{$model}RepositoryEloquent");
        }
    }
}

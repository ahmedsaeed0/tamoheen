<?php
namespace App\Providers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role; // تأكد من استيراد الفئة الصحيحة


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
   

    public function boot()
    {
        $this->registerPolicies();
    
        // Passport::ignoreRoutes();
    }
    // public function register()
    // {
    //     // تأكد من تسجيل الخدمة بشكل صحيح
    //     $this->app->singleton(Role::class, function ($app) {
    //         return new Role();
    //     });
    // }
}

<?php

namespace App\Providers;

use App\Enums\UserRoles;
use App\Models\Resume;
use Auth;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param GateContract $gate
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        $gate->define('create_vacancy', function () {
            return in_array(Auth::user()->role, [UserRoles::ADMIN_ROLE->value, UserRoles::RECRUITER_ROLE->value]);
        });


        $gate->define('view_all_resumes', function () {
            return in_array(Auth::user()->role, [UserRoles::ADMIN_ROLE->value, UserRoles::RECRUITER_ROLE->value]);
        });

        $gate->define('view_all_vacancy', function () {
            return Auth::user()->role == UserRoles::ADMIN_ROLE->value;
        });

        $gate->define('click_vacancy', function () {
            return Auth::user()->role == UserRoles::APPLICANT_ROLE->value;
        });

        $gate->define('view_statistics', function () {
            return Auth::user()->role == UserRoles::ADMIN_ROLE->value;
        });


        $gate->define('delete_resume', function ($user,$resume) {
            if(Auth::user()->role == UserRoles::ADMIN_ROLE->value)
                return true;
            else
                return $resume->user_id == Auth::user()->id;
        });
    }
}

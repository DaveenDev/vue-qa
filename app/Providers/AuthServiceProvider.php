<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Question;
use App\Policies\QuestionPolicy;
use App\Policies\AnswerPolicy;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Question::class=>QuestionPolicy::class,
        Answer::class=>AnswerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes(); //register necesary routes for api
        /* using gates to allow delete or update
        \Gate::define('update-question',function($user,$question){
            return $user->id === $question->user_id;
        });

        \Gate::define('delete-question',function($user,$question){
            return $user->id === $question->user_id;
        });
        */
    }
}

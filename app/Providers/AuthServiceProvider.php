<?php
// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use App\Models\ReadingSession;
use App\Policies\ReadingSessionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        ReadingSession::class => ReadingSessionPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
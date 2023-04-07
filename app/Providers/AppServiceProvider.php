<?php

namespace App\Providers;

use App\Interfaces\ChatInterface;
use App\Interfaces\UserInterface;
use App\Repositories\ChatRepository;
use App\Repositories\UserRepository;
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
        app()->bind(ChatInterface::class, ChatRepository::class);
        app()->bind(UserInterface::class, UserRepository::class);
    }
}

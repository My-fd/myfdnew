<?php

namespace App\Providers;

use App\Helpers\RedisHelper;
use Illuminate\Support\ServiceProvider;
use Redis;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RedisHelper::class, function () {
            $password = env('REDIS_PASSWORD');
            $redis    = new Redis();
            $redis->connect(env('REDIS_HOST', '127.0.0.1'), (int)env('REDIS_PORT', 6379));

            if ($password) {
                $redis->auth($password);
            }

            return new RedisHelper($redis);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

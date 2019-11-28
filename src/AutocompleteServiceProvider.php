<?php

namespace Ducha\Autocomplete;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;

/**
 * Class AutocompleteServiceProvider
 * @package Ducha\Autocomplete
 */
class AutocompleteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('autocomplete', function () {
            return new Autocomplete(Redis::connection());
        });
    }
}
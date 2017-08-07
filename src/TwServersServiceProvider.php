<?php

namespace Savander\TwServers;


use Illuminate\Support\ServiceProvider;

/**
 * Class TwServersServiceProvider
 *
 * @package Savander\TwServers
 */
class TwServersServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('Savander\TwServers', function () {
            return new TwServers();
        });
    }
}
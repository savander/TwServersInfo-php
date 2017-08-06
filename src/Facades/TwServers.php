<?php

namespace Savander\TwServers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class TwServers
 * @package Savander\TwServers\Facades
 */
class TwServers extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Savander\TwServers';
    }
}
<?php

namespace Savander\TwServers;


use Savander\TwServers\Server\ServerResolverInterface;

/**
 * Class TwServers
 *
 * @package Savander\TwServers
 */
class TwServers
{

    /**
     * Servers Object List
     *
     * @var array
     */
    protected $servers = [];

    /**
     * Add Server Object
     *
     * @var ServerResolverInterface $server
     */
    public function addServer(ServerResolverInterface $server)
    {
        $this->servers = $server;
    }


    /**
     * Return all servers
     *
     * @return array
     */
    public function getServers()
    {
        return $this->servers;
    }
}
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
     * TwServers constructor.
     */
    public function __construct()
    {
        return $this;
    }

    /**
     * TwServers constructor.
     *
     * @param \Savander\TwServers\Server\ServerResolverInterface|\Savander\TwServers\Server\ServerResolverInterface[] $servers
     *
     * @return $this
     */
    public function addServers($servers)
    {
        if (is_array($servers)) {
            foreach ($servers as $server) {
                $this->addServer($server);
            }
        } else {
            $this->addServer($servers);
        }

        return $this;
    }

    /**
     * Add Server Object
     *
     * @param \Savander\TwServers\Server\ServerResolverInterface $server
     *
     * @return $this
     */
    public function addServer(ServerResolverInterface $server)
    {
        $this->servers[$server->getIpAddress().':'.$server->getPort()]
            = $server;

        return $this;
    }


    /**
     * Return all servers
     *
     * @return array
     */
    public function getServers(): array
    {
        return $this->servers;
    }
}
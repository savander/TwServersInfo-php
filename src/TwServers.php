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
     * @var \Savander\TwServers\Server\ServerResolverInterface|\Savander\TwServers\Server\ServerResolverInterface[]|array
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
     * @param \Savander\TwServers\Server\ServerResolverInterface|\Savander\TwServers\Server\ServerResolverInterface[] $servers
     *
     * @return $this
     */
    public function addServers($servers)
    {
        if (is_array($servers)) {
            foreach ($servers as $server) {
                if ($server instanceof ServerResolverInterface) {
                    $this->addServer($server);
                }
            }
        } else if ($servers instanceof ServerResolverInterface) {
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
        if ($server->collectedData()) {
            $this->servers[$server->getIpAddress().':'.$server->getPort()]
                = $server;
        }

        return $this;
    }


    /**
     * Return all servers
     *
     * @return array|\Savander\TwServers\Server\ServerResolverInterface[]
     */
    public function getServers(): array
    {
        return $this->servers;
    }

    /**
     * @param string $index
     *
     * @return bool|mixed|\Savander\TwServers\Server\ServerResolverInterface
     */
    public function getServer(string $index)
    {
        if(strpos($index, ':') === false){
            $index .= ":".ServerResolverInterface::DEFAULT_PORT_SERVER;
        }
        echo $index;
        if (array_key_exists($index , $this->servers)) {
            return $this->servers[$index];
        }

        return false;
    }

    /**
     * @param \Savander\TwServers\Server\ServerResolverInterface|string $server
     *
     * @return bool|\Savander\TwServers\Player\PlayerInterface[]
     */
    public function getPlayers($server)
    {
        if ($server instanceof ServerResolverInterface) {
            return $server->getPlayers();
        } else if (is_string($server)) {
            if (in_array($server , $this->servers)) {
                return $this->servers[$server]->getPlayers();
            }
        }

        return false;
    }
}
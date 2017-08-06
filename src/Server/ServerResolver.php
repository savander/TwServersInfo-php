<?php

namespace Savander\TwServers\Server;

use Savander\TwServers\Player\PlayerInterface;

/**
 * Class ServerResolver
 *
 * @package Savander\TwServers\Server
 */
class ServerResolver implements ServerResolverInterface
{

    /**
     * ServerResolverInterface constructor.
     *
     * @param string $ipAddress
     * @param        $port
     */
    public function __construct(string $ipAddress, $port)
    {
        $this->resolveServer($ipAddress, $port);
    }

    /**
     * Resolve server by IpAddress
     *
     * @param string $ipAddress
     * @param        $port
     */
    public function resolveServer(string $ipAddress, $port)
    {
        // TODO: Implement resolveServer() method.
    }

    /**
     * Return players list
     *
     * @return PlayerInterface[]
     */
    public function getPlayers()
    {
        // TODO: Implement getPlayers() method.
    }

    /**
     * @param array $PlayerData
     */
    public function addPlayer(array $PlayerData)
    {
        // TODO: Implement addPlayer() method.
    }
}
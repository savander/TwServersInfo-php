<?php

namespace Savander\TwServers\Server;


use Savander\TwServers\Player\PlayerInterface;

/**
 * Interface ServerResolverInterface
 *
 * @package Savander\TwServers\Server
 */
interface ServerResolverInterface
{

    /**
     * ServerResolverInterface constructor.
     *
     * @param string $ipAddress
     * @param        $port
     */
    public function __construct(string $ipAddress, $port);

    /**
     * Resolve server by IpAddress
     *
     * @param string $ipAddress
     * @param        $port
     */
    public function resolveServer(string $ipAddress, $port);

    /**
     * Return players list
     *
     * @return PlayerInterface[]
     */
    public function getPlayers();

    /**
     * @param array $PlayerData
     */
    public function addPlayer(array $PlayerData);
}
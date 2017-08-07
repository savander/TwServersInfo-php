<?php

namespace Savander\TwServers\Server;


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
     * @param        $version
     */
    public function __construct(string $ipAddress, $port, $version);

    /**
     * Resolve server by IpAddress
     *
     * @param string $ipAddress
     * @param        $port
     * @param        $version
     *
     */
    public function resolveServer(string $ipAddress, $port, $version);

    /**
     * Return players list
     *
     * @return \Savander\TwServers\Player\PlayerInterface[]
     */
    public function getPlayers();

    /**
     * @param array $PlayerData
     */
    public function addPlayer(array $PlayerData);


}
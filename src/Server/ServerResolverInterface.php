<?php

namespace Savander\TwServers\Server;


/**
 * Interface ServerResolverInterface
 *
 * @package Savander\TwServers\Server
 */
interface ServerResolverInterface
{

    const DEFAULT_PORT_SERVER = 8303;

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
     * @return \Savander\TwServers\Player\PlayerInterface[]
     */
    public function getPlayers();

    /**
     * @param array $PlayerData
     */
    public function addPlayer(array $PlayerData);


}
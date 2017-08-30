<?php

namespace Savander\TwServers\MasterServer;


/**
 * Interface MasterServerResolverInterface
 *
 * @package Savander\TwServers\MasterServer
 */
interface MasterServerResolverInterface
{
    const DEFAULT_PORT_SERVER = 8300;

    /**
     * ServerResolverInterface constructor.
     *
     * @param string $ipAddress
     * @param        $port
     */
    public function __construct(string $ipAddress , $port);

    /**
     * Resolve server by IpAddress
     *
     * @param string $ipAddress
     * @param        $port
     *
     */
    public function resolveMasterServer(string $ipAddress , $port);


    /**
     * return server list from master server
     *
     * @return array
     */
    public function getServers(): array;

    /**
     * Return given port
     *
     * @return int
     */
    public function getPort(): int;


    /**
     * Return given ip address
     *
     * @return string
     */
    public function getIpAddress(): string;

    /**
     * Checks if server gives data
     *
     * @return bool
     */
    public function collectedData(): bool;



}
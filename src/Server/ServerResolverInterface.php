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
     * Return server name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Return server version
     *
     * @return mixed
     */
    public function getVersion();

    /**
     * return server player number
     *
     * @return mixed
     */
    public function getNumPlayers();

    /**
     * Return server max players variable
     *
     * @return mixed
     */
    public function getMaxPlayers();

    /**
     * return server map name
     *
     * @return mixed
     */
    public function getMapName();

    /**
     * return server gametype
     *
     * @return mixed
     */
    public function getGameType();

    /**
     * Return server flags
     *
     * @return mixed
     */
    public function getFlags();

    /**
     * Return given ip address
     *
     * @return mixed
     */
    public function getIpAddress();

    /**
     * Return given port
     *
     * @return mixed
     */
    public function getPort();
}
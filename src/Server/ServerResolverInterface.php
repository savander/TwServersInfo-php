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
     */
    public function __construct(string $ipAddress , $port);

    /**
     * Resolve server by IpAddress
     *
     * @param string $ipAddress
     * @param        $port
     *
     */
    public function resolveServer(string $ipAddress , $port);

    /**
     * Return players list
     *
     * @return \Savander\TwServers\Player\PlayerInterface[]
     */
    public function getPlayers();


    /**
     * Return token sent to server
     *
     * @return string
     */
    public function getToken(): string;

    /**
     * Return server name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Return server version
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * return server players number
     *
     * @return int
     */
    public function getNumPlayers(): int;

    /**
     * Return server max players variable
     *
     * @return int
     */
    public function getMaxPlayers(): int;

    /**
     * return server clients number
     *
     * @return int
     */
    public function getNumClients(): int;

    /**
     * Return server max clients variable
     *
     * @return int
     */
    public function getMaxClients(): int;


    /**
     * return server map name
     *
     * @return string
     */
    public function getMapName(): string;

    /**
     * return server gametype
     *
     * @return string
     */
    public function getGameType(): string;

    /**
     * Return server flags
     *
     * @return int
     */
    public function getFlags(): int;

    /**
     * Return given ip address
     *
     * @return string
     */
    public function getIpAddress(): string;

    /**
     * Return given port
     *
     * @return int
     */
    public function getPort(): int;


    /**
     * Returns if server has password
     *
     * @return bool
     */
    public function hasPassword(): bool;


    /**
     * Checks if server gives data
     *
     * @return bool
     */
    public function collectedData(): bool;
}
<?php

namespace Savander\TwServers\Player;


/**
 * Interface PlayerInterface
 * @package Savander\TwServers\Player
 */
interface PlayerInterface
{
    /**
     * PlayerInterface constructor.
     * @param array $PlayerData
     */
    public function __construct(array $PlayerData);

    /**
     * @param array $PlayerData
     */
    public function resolvePlayer(array $PlayerData);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getClan();

    /**
     * @return mixed
     */
    public function getScore();
}
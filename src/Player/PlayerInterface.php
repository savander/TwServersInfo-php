<?php

namespace Savander\TwServers\Player;


/**
 * Interface PlayerInterface
 *
 * @package Savander\TwServers\Player
 */
interface PlayerInterface
{

    /**
     * PlayerInterface constructor.
     *
     * @param array $PlayerData
     */
    public function __construct(array $PlayerData);

    /**
     * @param array $PlayerData
     */
    public function resolvePlayer(array $PlayerData);

    /**
     * @return string
     */
    public function getName(): string;


    /**
     * @return string
     */
    public function getClan(): string;

    /**
     * @return array
     */
    public function getCountry(): array;

    /**
     * @return bool
     */
    public function isPlayer(): bool;


    /**
     * @return int
     */
    public function getScore(): int;
}
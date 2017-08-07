<?php

namespace Savander\TwServers\Player;

/**
 * Class Player for version 0.5
 *
 * @package Savander\TwServers\Player
 */
class Player05 implements PlayerInterface
{


    public $name;

    public $score;


    /**
     * PlayerInterface constructor.
     *
     * @param array $PlayerData
     */
    public function __construct(array $PlayerData)
    {
        $this->resolvePlayer($PlayerData);
    }

    /**
     * @param array $PlayerData
     */
    public function resolvePlayer(array $PlayerData)
    {
        $this->name  = $PlayerData['name'];
        $this->score = (int)$PlayerData['score'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return (int)$this->score;
    }

}
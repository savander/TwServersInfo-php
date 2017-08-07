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
        $this->name     = $PlayerData['name'];
        $this->score    = $PlayerData['score'];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

}
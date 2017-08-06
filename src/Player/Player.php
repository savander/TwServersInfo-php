<?php

namespace Savander\TwServers\Player;

class Player implements PlayerInterface
{

    /**
     * PlayerInterface constructor.
     * @param array $PlayerData
     */
    public function __construct(array $PlayerData)
    {
        $this->resolvePlayer($PlayerData);
    }

    /**
     * @param array $PlayerData
     * @return mixed
     */
    public function resolvePlayer(array $PlayerData)
    {
        // TODO: Implement resolvePlayer() method.
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }

    /**
     * @return mixed
     */
    public function getClan()
    {
        // TODO: Implement getClan() method.
    }

    /**
     * @return mixed
     */
    public function getFlag()
    {
        // TODO: Implement getFlag() method.
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        // TODO: Implement getScore() method.
    }
}
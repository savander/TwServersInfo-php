<?php

namespace Savander\TwServers\Server;

use Savander\TwServers\Player\Player;
use Savander\TwServers\Player\PlayerInterface;

/**
 * Class ServerResolver
 *
 * @package Savander\TwServers\Server
 */
class ServerResolver implements ServerResolverInterface
{

    # Time before timeout will appear in connection
    const CONNECTION_TIMEOUT = 5;

    /**
     * PACKET_GETINFO for 0.5 and PACKET_GETINFO3 for 0.6+
     * https://github.com/teeworlds/teeworlds/blob/master/scripts/tw_api.py#L18-L22
     * Teeworlds 0.5 DATA
     **/
    const VERSION_05 = 5;

    const VERSION_05_DATA = "\xff\xff\xff\xff\xff\xff\xff\xff\xff\xffgief";

    # Teeworlds 0.6 DATA
    const VERSION_06 = 6;

    const VERSION_06_DATA = "\xff\xff\xff\xff\xff\xff\xff\xff\xff\xffgie3\x07";


    /**
     * Array of Players objects
     *
     * @var PlayerInterface[]
     */
    protected $players = [];

    # Teeworlds 0.6+
    protected $token;

    protected $version;

    protected $serverName;

    protected $mapName;

    protected $gametype;

    protected $flags;

    protected $numPlayers;

    protected $maxPlayers;

    # Teeworlds 0.6+
    protected $numClients;

    # Teeworlds 0.6+
    protected $maxClients;

    # Teeworlds 0.5
    protected $progression;


    /**
     * ServerResolverInterface constructor.
     *
     * @param string $ipAddress
     * @param        $port
     * @param int    $version
     */
    public function __construct(
        string $ipAddress,
        $port = self::DEFAULT_PORT_SERVER,
        $version = self::VERSION_06
    ) {
        $this->resolveServer($ipAddress, $port, $version);
    }

    /**
     * Resolve server by IpAddress
     *
     * @param string $ipAddress
     * @param        $port
     * @param int    $version
     *
     * @return bool
     */
    public function resolveServer(
        string $ipAddress,
        $port = self::DEFAULT_PORT_SERVER,
        $version = self::VERSION_06
    ) {
        # Try connect to server
        switch ($version) {
            case self::VERSION_05:
                $data = self::VERSION_05_DATA;
                break;
            case self::VERSION_06:
                $data = self::VERSION_06_DATA;
                break;
            default:
                $data = self::VERSION_06_DATA;
        }

        if ($serverInfo = $this->getServerData($ipAddress, $port, $data)) {
            $this->parseData($serverInfo, $version);
            dd($this->getPlayers());

            return true;
        }

        return false;
    }

    /**
     * Return players list
     *
     * @return PlayerInterface[]
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param array $PlayerData
     */
    public function addPlayer(array $PlayerData)
    {
        // TODO: Implement addPlayer() method.
    }


    /**
     * @param string $ipAddress
     * @param int    $port
     * @param string $data
     *
     * @return bool|string
     */
    public function getServerData(
        string $ipAddress,
        int $port,
        string $data
    ) {
        $sock = fsockopen(
            "udp://$ipAddress",
            (int)$port,
            $errno,
            $errst,
            self::CONNECTION_TIMEOUT
        );
        if ($sock) {
            fwrite($sock, $data);
            $data = fread($sock, 4092);
            //            $data = stream_get_contents($sock, 4092);
            fclose($sock);

            return $data;
        }

        return false;
    }

    /**
     * @param string $data
     * @param int    $version
     *
     * @return bool|void
     */
    public function parseData(string $data, int $version = self::VERSION_06)
    {
        # Remove header
        $data         = substr($data, 14);
        $explodedData = explode("\x00", $data);

        switch ($version) {
            case self::VERSION_05:
                $this->dataResolver05($explodedData);
                break;
            case self::VERSION_06:
                $this->dataResolver06($explodedData);
                break;
        }
    }

    /**
     * Parses data from server for Teeworlds 0.5
     *
     * @param array $data
     */
    public function dataResolver05(array $data)
    {
        $this->version     = $data[0];
        $this->serverName  = $data[1];
        $this->mapName     = $data[2];
        $this->gametype    = $data[3];
        $this->flags       = $data[4];
        $this->progression = $data[5];
        $this->numPlayers  = $data[6];
        $this->maxPlayers  = $data[7];
        for ($i = 0; $i < $this->numPlayers; $i++) {
            $player                         = [];
            $player['name']                 = $data[8 + $i * 2];
            $player['score']                = $data[8 + $i * 2 + 1];
            $this->players[$player['name']] = new Player05($player);
        }
    }

    /**
     * Parses data from server for Teeworlds 0.6+
     *
     * @param array $data
     */
    public function dataResolver06(array $data)
    {
        $this->token      = $data[0];
        $this->version    = $data[1];
        $this->serverName = $data[2];
        $this->mapName    = $data[3];
        $this->gametype   = $data[4];
        $this->flags      = $data[5];
        $this->numPlayers = $data[6];
        $this->maxPlayers = $data[7];
        $this->numClients = $data[8];
        $this->maxClients = $data[9];
        for ($i = 0; $i < $this->numClients; $i++) {
            $player                         = [];
            $player['name']                 = $data[10 + $i * 5];
            $player['clan']                 = $data[10 + $i * 5 + 1];
            $player['country']              = $data[10 + $i * 5 + 2];
            $player['score']                = $data[10 + $i * 5 + 3];
            $player['isPlayer']             = $data[10 + $i * 5 + 4];
            $this->players[$player['name']] = new Player($player);
        }
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getServerName()
    {
        return $this->serverName;
    }

    /**
     * @return mixed
     */
    public function getMapName()
    {
        return $this->mapName;
    }

    /**
     * @return mixed
     */
    public function getGametype()
    {
        return $this->gametype;
    }

    /**
     * @return mixed
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @return mixed
     */
    public function getNumPlayers()
    {
        return $this->numPlayers;
    }

    /**
     * @return mixed
     */
    public function getMaxPlayers()
    {
        return $this->maxPlayers;
    }

    /**
     * @return mixed
     */
    public function getNumClients()
    {
        return $this->numClients;
    }

    /**
     * @return mixed
     */
    public function getMaxClients()
    {
        return $this->maxClients;
    }

    /**
     * @return mixed
     */
    public function getProgression()
    {
        return $this->progression;
    }



}
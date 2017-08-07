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
    const CONNECTION_TIMEOUT = 2;

    const DEFAULT_PORT_SERVER = 8303;

    const SERVER_FLAG_PASSWORD = 0x1;

    /**
     * PACKET_GETINFO3 for 0.6+
     * https://github.com/teeworlds/teeworlds/blob/master/scripts/tw_api.py#L18-L22
     **/
    const DATA_TO_SEND = "\xff\xff\xff\xff\xff\xff\xff\xff\xff\xffgie3\x07";


    /**
     * Array of Players objects
     *
     * @var PlayerInterface[]
     */
    protected $players = [];

    protected $token;

    protected $numClients;

    protected $maxClients;

    protected $version;

    protected $serverName;

    protected $mapName;

    protected $gametype;

    protected $flags;

    protected $numPlayers;

    protected $maxPlayers;

    protected $ipAddress;

    protected $port;

    protected $collectedData = false;

    /**
     * ServerResolverInterface constructor.
     *
     * @param string $ipAddress
     * @param        $port
     */
    public function __construct(
        string $ipAddress ,
        $port = self::DEFAULT_PORT_SERVER
    ) {
        $this->resolveServer($ipAddress , $port);
        $this->ipAddress = $ipAddress;
        $this->port      = $port;
    }

    /**
     * Resolve server by IpAddress
     *
     * @param string $ipAddress
     * @param        $port
     *
     * @return bool
     */
    public function resolveServer(
        string $ipAddress ,
        $port = self::DEFAULT_PORT_SERVER
    ): bool {
        if ($serverInfo = $this->getServerData($ipAddress , $port)) {
            $this->parseData($serverInfo);

            return true;
        }

        return false;
    }

    /**
     * @param string $ipAddress
     * @param int    $port
     *
     * @return bool|string
     */
    protected function getServerData(
        string $ipAddress ,
        int $port
    ) {
        $sock = fsockopen(
            "udp://$ipAddress" ,
            (int)$port ,
            $errno ,
            $errst ,
            self::CONNECTION_TIMEOUT
        );

        # If no data, timeout after specific time
        stream_set_timeout($sock , 1);

        if ($sock) {
            fwrite($sock , self::DATA_TO_SEND);
            $data = fread($sock , 2048);
            fclose($sock);

            return $data;
        }

        return false;
    }

    /**
     * @param string $data
     *
     * @return bool
     */
    public function parseData(string $data)
    {
        # Remove header
        $data         = substr($data , 14);
        $explodedData = explode("\x00" , $data);

        if (sizeof($explodedData) > 9) {
            $this->dataResolver($explodedData);
        }

        return false;
    }

    /**
     * Parses data from server for Teeworlds 0.6+
     *
     * @param array $data
     */
    public function dataResolver(array $data)
    {
        $this->token      = $data[0];
        $this->version    = $data[1];
        $this->serverName = $data[2];
        $this->mapName    = $data[3];
        $this->gametype   = $data[4];
        $this->flags      = (int)$data[5];
        $this->numPlayers = (int)$data[6];
        $this->maxPlayers = (int)$data[7];
        $this->numClients = (int)$data[8];
        $this->maxClients = (int)$data[9];

        #check if enough data for players
        if (sizeof($data) > (9 + $this->numClients * 5)) {
            for ($i = 0; $i < $this->numClients; $i++) {
                $player                         = [];
                $player['name']                 = $data[10 + $i * 5];
                $player['clan']                 = $data[10 + $i * 5 + 1];
                $player['country']              = (int)$data[10 + $i * 5 + 2];
                $player['score']                = (int)$data[10 + $i * 5 + 3];
                $player['isPlayer']             = $data[10 + $i * 5 + 4];
                $this->players[$player['name']] = new Player($player);
            }
            $this->collectedData = true;
        }
    }

    /**
     * Return players list
     *
     * @return \Savander\TwServers\Player\PlayerInterface[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->serverName;
    }

    /**
     * @return string
     */
    public function getMapName(): string
    {
        return $this->mapName;
    }

    /**
     * @return string
     */
    public function getGametype(): string
    {
        return $this->gametype;
    }

    /**
     * @return int
     */
    public function getFlags(): int
    {
        return (int)$this->flags;
    }

    /**
     * @return int
     */
    public function getNumPlayers(): int
    {
        return (int)$this->numPlayers;
    }

    /**
     * @return int
     */
    public function getMaxPlayers(): int
    {
        return (int)$this->maxPlayers;
    }

    /**
     * @return int
     */
    public function getNumClients(): int
    {
        return (int)$this->numClients;
    }

    /**
     * @return int
     */
    public function getMaxClients(): int
    {
        return (int)$this->maxClients;
    }

    /**
     * Return given server address
     *
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * Return given port
     *
     * @return int
     */
    public function getPort(): int
    {
        return (int)$this->port;
    }


    /**
     * Password has password?
     *
     * @return bool
     */
    public function hasPassword(): bool
    {
        return ($this->flags & self::SERVER_FLAG_PASSWORD)
            === self::SERVER_FLAG_PASSWORD;
    }


    /**
     * Check if server gave data
     *
     * @return bool
     */
    public function collectedData(): bool
    {
        return $this->collectedData;
    }
}
<?php

namespace Savander\TwServers\MasterServer;


/**
 * Class ServerResolver
 *
 * @package Savander\TwServers\Server
 */
class MasterServerResolver implements MasterServerResolverInterface
{

    # Time before timeout will appear in connection
    const CONNECTION_TIMEOUT = 2;

    /**
     * PACKET_LIST2 for 0.6+
     * https://github.com/teeworlds/teeworlds/blob/master/scripts/tw_api.py#L18-L22
     **/
    const DATA_TO_SEND = "\x20\x00\x00\x00\x00\x00\xff\xff\xff\xffreq2";


    /**
     * Array of servers ip addresses
     *
     * @var array
     */
    protected $serversList = [];

    protected $ipAddress;

    protected $port;

    protected $collectedData = false;

    /**
     * MasterServerResolverInterface constructor.
     *
     * @param string $ipAddress
     * @param        $port
     */
    public function __construct(
        string $ipAddress ,
        $port = self::DEFAULT_PORT_SERVER
    ) {
        $this->resolveMasterServer($ipAddress , $port);
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
    public function resolveMasterServer(
        string $ipAddress ,
        $port = self::DEFAULT_PORT_SERVER
    ): bool {
        if ($serverList = $this->getMasterServerData($ipAddress , $port)) {

            foreach($serverList as $item){
                $this->parseData($item);
            }
            $this->collectedData = true;
            return true;
        }

        return false;
    }

    /**
     * @param string $ipAddress
     * @param int    $port
     *
     * @return bool|array
     */
    protected function getMasterServerData(
        string $ipAddress ,
        int $port
    ) {
        $socket = fsockopen(
            "udp://$ipAddress" ,
            (int)$port ,
            $errno ,
            $errst ,
            self::CONNECTION_TIMEOUT
        );

        # If no data, timeout after specific time
        stream_set_timeout($socket , 1);

        if ($socket) {
            fwrite($socket , self::DATA_TO_SEND);
            $response = fread($socket , 2048);

            $data = [];

            while(strlen($response) >= 1) {
                $data[] = $response;
                $response = fread($socket , 2048);
            }

            fclose($socket);

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
        $data = substr($data , 14);
        $numServers = strlen($data) / 18;

        for ($iterator = 0; $iterator <= $numServers; $iterator++) {

            #IPv4
            if (substr($data , $iterator * 18 , 12)
                == "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\xff\xff"
            ) {
                $ipAddress = implode('.' , array_map("ord" ,
                    str_split(substr($data , $iterator * 18 + 12 , 4))));
            } #IPv6
            else {
                $ipAddress = implode(':' , array_map("ord" ,
                    str_split(substr($data , $iterator * 18 , 16))));
            }
            $port = (ord(substr($data , $iterator * 18 + 16)) << 8)
                + ord(substr($data , $iterator * 18 + 17));

            $this->serversList[] = [
                $ipAddress ,
                "ipAddress" => $ipAddress ,
                $port ,
                "port"      => $port,
            ];
        }
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
     * Check if server gave data
     *
     * @return bool
     */
    public function collectedData(): bool
    {
        return $this->collectedData;
    }

    /**
     * return server list from master server
     *
     * @return array
     */
    public function getServers(): array
    {
        return $this->serversList;
    }
}
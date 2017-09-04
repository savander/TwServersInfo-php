# TwServersInfo-php
PHP Library (+Laravel) - Teeworlds Servers Info
This package, allows you to gather information from Teeworlds Servers as well as from TeeWorlds Master Servers. 
## Requirements

- PHP ^7.0

## Composer

Require this package with composer using the following command:
```
composer require savander/twservers
```
To install this package on only development systems, add the `--dev` flag to your composer command:
```
composer require --dev savander/twservers
```

#### for Laravel
##### Laravel 5.5+
Laravel 5.5 introduced package autodiscover. It means, that you don't need to aliases and providers to your app by your own.

##### For Laravel 5.4~
After updating composer, add the service provider to the `providers` array in `config/app.php`
```php
Savander\TwServers\TwServersServiceProvider::class,
```

Also, add the Facade to the `aliases` array in `config/app.php`
```php
'TwServers' => Savander\TwServers\Facades\TwServers::class,
```

## Usage (examples based on Laravel Facade)

### Teeworlds Servers
Gathering information from server/servers can consume some time.

You can **add one or few servers** to object by passing `array`  
```php
$servers = TwServers::addServers([
        new ServerResolver('192.168.0.1', 8303),
        new ServerResolver('192.168.0.2', 8305)
    ]
);
```
or `ServerResolver` class directly to function. (You don't have to pass `port`, by default it is `8303`)
```php
$servers = TwServers::addServer(
        new ServerResolver('192.168.0.1')
);

```

To list every server you added, use `getServers()` function

```php
  $servers->getServers();

```
It will return list of servers you passed to object, with data from server. 

You can automatically get Players from servers by using `getPlayers()` function. 
You can pass `ServerResolverInterface` object, or string like `ip:port` to get data from already added server.
```php
$servers = TwServers::getPlayers(
        new ServerResolver('192.168.0.1')
);

# Array of Player objects
$players = $server->getPlayers();

```

To get specific server from already added, use function `getServer(string $string)`
```php

# Index as a combination of ip and port => ip:port or
#                                          ip (only if standard port 8303)
$server = $servers->getServer('192.168.0.1')
```


`ServerResolver` has some function, which you can use, check `ServerResolverInterface`:
[**ServerResolverInterface.php**](https://github.com/savander/TwServersInfo-php/blob/master/src/Server/ServerResolverInterface.php)

If server has players, ServerResolver stores PlayerInterface, which has some function as well: 
[**PlayerInterface**](https://github.com/savander/TwServersInfo-php/blob/master/src/Player/PlayerInterface.php)


### Teeworlds Master Servers
Gathering information from master servers can consume some time.


You can **add one or few servers** to object by passing `array`  
```php
$servers = TwServers::addMasterServers([
       new MasterServerResolver('master1.teeworlds.com', 8300),
       new MasterServerResolver('master2.teeworlds.com', 8300),
       new MasterServerResolver('master3.teeworlds.com'),
       new MasterServerResolver('master4.teeworlds.com')
    ]
);
```
or `MasterServerResolver` class directly to function. (You don't have to pass `port`, by default it is `8300`)
```php
$servers = TwServers::addMasterServer(
        new MasterServerResolver('master2.teeworlds.com')
);

```

To list every server you added, use `getMasterServers()` function

```php
  $servers->getMasterServers();

```
It will return list of servers you passed to object, with data from masterserver. 


To get specific masterserver from already added, use function `getMasterServer(string $string)`
```php

# Index as a combination of ip and port => ip:port or
#                                          ip (only if standard port 8300)
$server = $servers->getMasterServer('master2.teeworlds.com')
```


`MasterServerResolver` has some function, which you can use, check `MasterServerResolverInterface`:
[**MasterServerResolverInterface.php**](https://github.com/savander/TwServersInfo-php/blob/master/src/MasterServer/MasterServerResolverInterface.php)

___
**Feel free to add your own version based on those interfaces.**

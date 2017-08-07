# TwServersInfo-php
PHP Library (+Laravel) - Teeworlds Servers Info

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
After updating composer, add the service provider to the `providers` array in `config/app.php`
```php
Savander\TwServers\TwServersServiceProvider::class,
```

Also, add the Facade to the `aliases` array in `config/app.php`
```php
'TwServers' => Savander\TwServers\Facades\TwServers::class,
```

## Usage (examples based on Laravel Facade)

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

# Index as a combination of ip and port => ip:port or
                                           ip (only if standard port 8303)
$server = $servers->getServer('192.168.0.1')

# Array of Player objects
$players = $server->getPlayers();

```
`ServerResolver` has some function, which you can use, check `ServerResolverInterface`:
[**ServerResolverInterface.php**](https://github.com/savander/TwServersInfo-php/blob/master/src/Server/ServerResolverInterface.php)

If server has players, ServerResolver stores PlayerInterface, which has some function as well: 
[**PlayerInterface**](https://github.com/savander/TwServersInfo-php/blob/master/src/Player/PlayerInterface.php)


**Feel free to add your own version based on those interfaces.**

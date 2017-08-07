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

## Usage

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
$server = TwServers::addServers(
        new ServerResolver('192.168.0.1')
);
```

To read data, use `getServers()` function

```php
  $server->getServers();

```
It will return list of servers you passed to object, with data from server. 

Get Players from the specific server:
```php
$servers = TwServers::addServers([
        new ServerResolver('192.168.0.1', 8303),
        new ServerResolver('192.168.0.2', 8305)
    ]
);

# Index as a combination of ip and port => ip:port
$server = $servers->getServers()['192.168.0.1:8303'];

# Array of Player objects
$players = $server->getPlayers();

```

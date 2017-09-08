# file-config
Sets the storage format of the configuration file

## Example

update file_config.php

```
'files'=>[
    /tmp/crcms,
    // Set up other parsing drivers
    /tmp/crcms => \CrCms\FileConfig\Drives\SerializeConfig::class,
    
],

'default_drive'=>\CrCms\FileConfig\Drives\DefaultConfig::class,
```

put

```
file_config([
    crcms.a=>'a',
    crcms.b=>'b'
])
```

get

```
file_config('crcms.a')
```

all

```
file_config('crcms')
```

destroy

```
file_config()->destroy('crcms.a')
```

0.0.2 above the new load method

```
Example test.php
key1=>value1
key2=>value2

//get all
file_config()->load('/path/test.conf')->all('test')
```

0.0.3 Add multiple dot depth support

file_config()->load('/path/test.conf')->get('test.depth1.depth2.0')

## Install

You can install the package via composer:

```
composer require crcms/file-config
```

## Laravel

Modify ``config / app.php``

```
'providers' => [
    CrCms\FileConfig\FileConfigServiceProvider::class,
]


'aliases' => [
    'FileConfig' => \CrCms\FileConfig\Facades\FileConfig::class
],
```

If you'd like to make configuration changes in the configuration file you can pubish it with the following Aritsan command:
```
php artisan vendor:publish --provider="CrCms\FileConfig\FileConfigServiceProvider"
```

## Laravel Testing

```
phpunit ./tests/Config
```

## License
MIT
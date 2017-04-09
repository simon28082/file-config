# file-config
Sets the storage format of the configuration file

## Example

file_config

```$xslt
'files'=>[
    /tmp/crcms
],

'default_drive'=>\CrCms\FileConfig\Drives\DefaultConfig::class,
```

put

```$xslt
file_config([
    crcms.a=>'a',
    crcms.b=>'b'
])
```

get

```$xslt
file_config('crcms.a')
```

all

```$xslt
file_config('crcms')
```

destroy

```$xslt
file_config()->destroy('crcms.a')
```

## Install

You can install the package via composer:

```$xslt
composer require crcms/file-config
```

## Laravel

Modify ``config / app.php``

```$xslt
'providers' => [
    CrCms\FileConfig\FileConfigServiceProvider::class,
]


'aliases' => [
    'FileConfig' => \CrCms\FileConfig\Facades\FileConfig::class
],
```

If you'd like to make configuration changes in the configuration file you can pubish it with the following Aritsan command:
```$xslt
php artisan vendor:publish --provider="CrCms\FileConfig\FileConfigServiceProvider"
```

## Laravel Testing
````
```$xslt
phpunit ./tests/Config
```

## License
MIT
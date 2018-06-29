# PaymentServices
Payment services for BNL POSitivity

## Install

```sh
composer install
```

## Testing

This prject use [PHPUnit](https://phpunit.de/getting-started/phpunit-6.html)

```sh
$ ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/EmailTest
```

## Debug
install XDEBUG

for windows: 
```powershell
[environment]::SetEnvironmentVariable('XDEBUG_CONFIG','idekey=VSCODE')
```
```ini
;extension=php_curl.dll the semicolon must be removed 
zend_extension = ext\{xdebug_filename}
[XDebug]
xdebug.remote_enable = 1
xdebug.remote_autostart = 1
```

end

# PaymentServices
Payment services for BNL POSitivity

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


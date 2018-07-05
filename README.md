# PaymentServices
Payment services for BNL POSitivity

# Useful links

[https://www.bnlpositivity.it/area-sviluppatori/](https://www.bnlpositivity.it/area-sviluppatori/)

[https://www.bnlpositivity.it/area-sviluppatori/api-e-webservices/](https://www.bnlpositivity.it/area-sviluppatori/api-e-webservices/)

[https://www.bnlpositivity.it/code-snippets/tabella-5-script-php-pagamento-online/](https://www.bnlpositivity.it/code-snippets/tabella-5-script-php-pagamento-online/)

[https://github.com/ravisaxena2006/igfs-payment-gateway](https://github.com/ravisaxena2006/igfs-payment-gateway)

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
for linux & mac
````
sudo apt-get install php5-xdebug

````
```
xdebug.remote_enable = 1
xdebug.remote_port = 9000
xdebug.idekey = PHPSTORM
xdebug.show_error_trace = 1
xdebug.remote_autostart = 0
xdebug.file_link_format = phpstorm://open?%f:%l
```
```
Linux
sudo service apache2 restart

# MacOS

sudo apachectl restart

```

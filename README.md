# PaymentServices
Payment services for BNL POSitivity

# Useful links

[https://www.bnlpositivity.it/area-sviluppatori/](https://www.bnlpositivity.it/area-sviluppatori/)

[https://www.bnlpositivity.it/area-sviluppatori/api-e-webservices/](https://www.bnlpositivity.it/area-sviluppatori/api-e-webservices/)

[https://www.bnlpositivity.it/code-snippets/tabella-5-script-php-pagamento-online/](https://www.bnlpositivity.it/code-snippets/tabella-5-script-php-pagamento-online/)

[https://github.com/ravisaxena2006/igfs-payment-gateway](https://github.com/ravisaxena2006/igfs-payment-gateway)

## Install

Add the repository in your composer.json file. Run the command below in your terminal/console under root/ folder
```sh
composer config repositories.Bnlpositivity/PaymentServices vcs https://github.com/AXEPTAPLUGIN/PaymentServices
```
Run the following command: 
```sh
composer require Bnlpositivity/PaymentServices:dev-master
```
Composer will install necessary files,then run the following command to re-generate classmap and autoload files
```sh
 composer dump-autoload 
```

## Testing

This prject use [PHPUnit](https://phpunit.de/getting-started/phpunit-6.html)

```sh
$ ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/IgfcTest
```

or a simple method:

```sh
$ ./vendor/bin/phpunit --bootstrap vendor/autoload.php --filter testInit tests/IgfcTest
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

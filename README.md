Site-Skeleton
===========

It's a simple silex site.

## Install

``` bash
git clone https://github.com/kosssi/Site-Skeleton.git
cd Site-Skeleton
curl -s http://getcomposer.org/installer | php
php composer.phar install

```

## launch dev server

``` bash
curl -L http://github.com/downloads/benja-M-1/symfttpd/symfttpd.phar 2> /dev/null > symfttpd.phar
php symfttpd.phar spawn -p 1872

```

## launch prod server (Apache)

``` bash
# web/.htaccess
<IfModule mod_rewrite.c>
    Options -MultiViews

    RewriteEngine On
    #RewriteBase /var/www/..
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

```

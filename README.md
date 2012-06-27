studying-symfony2
=================

**This is just my study project.**

This is an application made with Symfony2(PHP Web Application Framework).


ENVIRONMENT
-----------
My environment:

- CentOS 6.2 (Minimal install)
- nginx 1.2.x
- PHP 5.4.x with APC, Xdebug
- MySQL 5.1.x

Running php-fpm with nginx.
But Apache is easier to run Symfony2 because the rewrite rule is provided by Symfony2.


GETTING STARTED
---------------

1. Clone this repository.
2. Setup virtual host and configure document root to `web` directory.
3. Setup permissions. (See http://symfony.com/doc/current/book/installation.html#configuration-and-setup)
4. Copy `app/config/parameters.ini.dist` to `app/config/parameters.ini` and change parameters according to you environment.
5. Run `php bin/vendors install --reinstall` (Git is required)
6. Run `php app/console doctrine:database:create`, or manuall create your database.
7. Run `php app/console doctrine:schema:create`
8. Run `php app/console doctrine:fixtures:load`
9. Access `http://your_server/app_dev.php/example/`

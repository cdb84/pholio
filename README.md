# photofolio
A PHP system for managing photography portfolios.
## Setup
1. Edit INIT.htaccess of the admin/ directory to reflect the proper passwd file, then rename INIT.htaccess to just .htaccess
1. Import INIT.sql into any database accessible by the webserver.
1. Edit connection.php to reflect your database configuration.
1. Ensure that the webserver can edit the filestructure of the root directory for this application.
## Dependencies
1. PHP 5
1. MySQLi 
1. The `convert` utility from ImageMagick, available to be executed from the shell by the webserver
1. I would recommend mcrypt PHP module if you're going to be using PHPMyAdmin
1. It may be necessary to change your PHP.ini and/or PHP conf to allow for uploads greater than 8 megabytes.

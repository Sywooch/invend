INVEND SYS APP
==============

COMPOSER
--------

Download and Install Composer from this link https://getcomposer.org/download/

Run the following commands

cd c:/xampp/htdocs/leaseapp

composer global require "fxp/composer-asset-plugin:~1.1.1"
composer install
composer update

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=leaseapp_db',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```


MIGRATION
----------

cd c:/xampp/htdocs/inventory

.\yii migrate --migrationPath=@mdm/admin/migrations

.\yii migrate --migrationPath=@yii/rbac/migrations

.\yii migrate/up

.\yii rbac/init



RUN ON PRODUCTION
-----------------

Edit the file `web/index.php` with real data, for example:

Comment out the first two lines

<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();



URL ACCESS
----------

Example 

http://localhost:port/leaseapp/web

username: admin

password: admin@101#

Reports
---------
http://localhost:8088/leaseapp/web/reportico



TASK REMAINING
--------------

Export Agreement to pdf for printing and signing
Only show Bank Info Form if Cheque is selected and make it mandatory
Reports
Dashboard
Property Management
	property made inactive after agreement
	property release

Agreement Issues
----------------
delete
update

i.e if there is a record refuse deletion and update for agreement else delete all payment plan in relation to agreement and form another one base on the update



Heroku

composer install

$ heroku addons:add heroku-postgresql
...

$ heroku config
=== example-app Config Vars
DATABASE_URL:               postgres://{user}:{password}@{hostname}:{port}/{database-name}
HEROKU_POSTGRESQL_AQUA_URL: postgres://{user}:{password}@{hostname}:{port}/{database-name}

php yii migrate/up


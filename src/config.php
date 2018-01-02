<?php
// the path to your web site. 
// if you are at the root dir of your domain, this can be an empty string.
// otherwise, use an url like http://example.com
define('APPPATH', '');
//just like above, just for the subfolder /ajax.
//either /ajax 
//or http://example.com/ajax
define('SERVICEPATH', '/ajax');
//the domain to use for openID authentification
define('OPENID_DOMAIN', 'example.com');

//chado database
define('DB_ADAPTER','pgsql');
define('DB_CONNSTR', 'pgsql:host=${chado_db_host};dbname=${chado_db_name};port=${chado_db_port}');
define('DB_USERNAME', '${chado_db_username}');
define('DB_PASSWORD', '${chado_db_password}');

//database connection for the "blast-cron" database
define('QUEUE_DB_CONNSTR', 'pgsql:host=${queue_db_host};dbname=${queue_db_name};port=${queue_db_port}');
define('QUEUE_DB_USERNAME', '${queue_db_username}');
define('QUEUE_DB_PASSWORD', '${queue_db_password}');

//when a user visits the page for the first time, these will be selected
define('DEFAULT_ORGANISM', 1);
define('DEFAULT_RELEASE', 'test_release');

//set error reporting to a level that suits you
error_reporting(E_ALL ^ E_STRICT ^ E_NOTICE);
ini_set('display_errors', '0');

//use memcached (http://memcached.org/) for caching feature descriptions
//disable if you want to use file caching instead (not recommended)
define('MEMCACHED_ENABLED', TRUE);
define('MEMCACHED_HOST', 'localhost');
define('MEMCACHED_PORT', 11211);
//file cache location (only needed if memcached is disabled)
define('FILE_CACHE_DIR', '/tmp/zendcache/details_features');

//user limits on the number of carts, elements and annotations
define('MAX_CARTS_PER_CONTEXT', 100);
define('MAX_ITEMS_PER_CART', 10000);
define('MAX_ANNOTATIONS_PER_CONTEXT', 100000);
define('MAX_CHARS_USER_ALIAS', 100);
define('MAX_CHARS_USER_DESCRIPTION', 1000);
define('MAX_CHARS_CARTNAME', 100);
define('MAX_CHARS_CARTNOTES', 1000);

//perform a check that each isoform/unigene belongs to the given organism/release before adding to cart
//in general this check is a good idea but the implementation is very time/memory consuming when there are lots of (100k+) features in the database
//see https://github.com/TBroTeam/TBro/issues/59
define('CHECK_ITEMS_ON_ADD', TRUE);

//path to your impressum.html file (relative to your index.php or absolute)
define('IMPRESSUM_FILE', 'impressum.example.html');

//google analytics id (if you don't want to use google analytics, just leave commented)
//define('GOOGLE_ANALYTICS_ID', '');

//OpenID for default carts. The carts of this OpenID user are provided for all users that are not logged in
//No not-logged-in user can alter those carts persistently - this can only be done by the OpenID user (when logged in)
//Leave this commented out if you do not want to provide default carts for not-logged-in users
//define('DEFAULT_CART_OPENID', '');

//uncomment for debugging
//if (isset($_REQUEST['DEBUG']))
//    define('DEBUG', true);
//error_reporting(E_ALL );
//ini_set('display_errors', '1');

//Title on the welcome page (html allowed)
define('INSTANCE_TITLE', '<span style="color: #2ba6cb">T</span>ranscriptome <span style="color: #2ba6cb">Bro</span>wser');
define('LOGO_URL', APPPATH.'/img/tbro_logo.svg');
?>

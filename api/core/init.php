<?php
session_start();

$GLOBALS['config'] = array(
    'mysql'     => array(
        /* test server
        'host'          => 'mysql.hostinger.ro',
        'username'      => 'u956180736_user',
        'password'      => 'parolauser',
        'db'            => 'u956180736_shopp'
        */
        ///* local
        'host'          => 'localhost',
        'username'      => 'root',
        'password'      => '',
        'db'            => 'u956180736_shopp'
        //*/
    ),
    'remember'  => array(
        'cookie_name'   => 'hash',
        'cookie_expiry' => 604800
    ),
    'session'   => array(
        'session_name'  => "user",
        'token_name'    => "token"
    )
);

spl_autoload_register(function($class){
    require_once 'classes/'.$class.'.php';
});

require_once 'functions/sanitize.php';


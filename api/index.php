<?php
    require_once('core/init.php');
    $user = DB::getInstance()->insert('companies', array(
        'company_name' => 'First Company',
        'username'     => 'username',
        'password'     => 'password',
    ));
?>
<?php

require_once 'core/init.php';

$user =DB::getInstance()->update('users', 3, array(
    'username' => 'Dale Kenz',
    'password' => 'newPassword',
));

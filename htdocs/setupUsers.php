<?php

require_once(dirname(__FILE__) . "/lib/ClassLoader.php");

$user = CrUser::loadOrCreateUser("userName");
$user->setPassword("password");
$user->setEmail("email");
$user->setCanCreate(true);
$user->setCanDelete(true);
$user->setCanDeleteForeign(true);
$user->setCanEdit(true);
$user->setCanEditForeign(true);
$user->saveToDatabase();








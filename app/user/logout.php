<?php

require_once "../config/autoload.php";

$user = new User();
$user->logout();
header("Location:auth/signin.php");

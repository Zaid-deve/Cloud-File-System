<?php

require_once "app/config/autoload.php";
echo "<pre>";
print_r(getFilesMeta($db, $uid, 0));

?>

<?php

require_once "app/config/autoload.php";

echo $user->isFileUploadLimitExceeded($db, $uid, $authType);

?>

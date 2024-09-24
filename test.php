<?php

require_once "app/config/autoload.php";
require_once "app/php/b2/b2file.php";


$b2 = new B2File();
echo $b2->getDownloadUrl('dadad');
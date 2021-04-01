<?php

require __DIR__.'/vendor/autoload.php';

use   \App\Session\Login;

define('TITLE', 'Painel de controle');
define('BRAND', 'Painel de controle ');


Login::requireLogin();



include __DIR__.'/includes/header.php';
include __DIR__.'/includes/top.php';
include __DIR__.'/includes/menu.php';
include __DIR__.'/includes/content.php';
include __DIR__.'/includes/box-infor.php';
include __DIR__.'/includes/footer.php';


?>
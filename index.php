<?php

session_start();

ini_set('memory_limit', '175M');
define('USE_HTTP_KEEPALIVE', true);

include 'login.php';

if (!(booL) $_SESSION['auth']) {
    include 'login.html';
} else {
    include 'content.php';
}
<?php

if ($_POST['auth'] && $_POST['auth'] === 'phasmo') {
    $_SESSION['auth'] = 1;
}
<?php
session_start();

require_once '_fonctions.inc.php';


if (isset($_POST['logout'])) {

    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

?>
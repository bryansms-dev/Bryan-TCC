<?php

require_once("auth_check.php");    //garante que tá logado primeiro

if (($_SESSION['tipo'] ?? '') !== 'admin') {

    header("Location: conta.php");
    exit();
}
?>

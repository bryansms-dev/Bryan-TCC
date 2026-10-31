<?php

$servidor = "localhost";
$user = "root";
$senha = "";
$banco = "coffee_tasty";

$conexao = new mysqli ($servidor, $user, $senha, $banco);


if ($conexao -> connect_error) {
    die ("falha na conexão: " . $conexao -> connect_error);
}

$conexao -> set_charset("utf8mb4");

?>
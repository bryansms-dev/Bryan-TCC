<?php
require_once("admin_check.php");
include("conexao.php");

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $conexao->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$conexao->close();
header("Location: admin_table.php");
exit();
?>

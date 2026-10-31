<?php
require_once("admin_check.php");
include("conexao.php");

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
   
    if ($id === (int) $_SESSION['usuario_id']) {
        header("Location: admin_table.php");
        exit();
    }

    $stmt = $conexao->prepare("SELECT tipo FROM admin WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $atual = $resultado->fetch_assoc()['tipo'];
        $novo = $atual === 'admin' ? 'usuario' : 'admin';

        $stmt2 = $conexao->prepare("UPDATE admin SET tipo = ? WHERE id = ?");
        $stmt2->bind_param("si", $novo, $id);
        $stmt2->execute();
        $stmt2->close();
    }
    $stmt->close();
}

$conexao->close();
header("Location: admin_table.php");
exit();
?>

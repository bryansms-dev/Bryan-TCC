<?php
require_once("admin_check.php");
include("conexao.php");

$id = trim($_POST['id'] ?? '');
$nome = trim($_POST['nome'] ?? '');
$preco = $_POST['preco'] ?? '';
$preco_antigo = trim($_POST['preco_antigo'] ?? '') === '' ? null : $_POST['preco_antigo'];
$imagem = trim($_POST['imagem'] ?? '');

if ($nome === '' || $preco === '' || $imagem === '') {
    die("Preencha nome, preço e imagem. <a href='admin_table.php'>Voltar</a>");
}

if ($id === '') {
  
    $stmt = $conexao->prepare("INSERT INTO produtos (nome, preco, preco_antigo, imagem) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdds", $nome, $preco, $preco_antigo, $imagem);
} else {
   
    $id = (int) $id;
    $stmt = $conexao->prepare("UPDATE produtos SET nome=?, preco=?, preco_antigo=?, imagem=? WHERE id=?");
    $stmt->bind_param("sddsi", $nome, $preco, $preco_antigo, $imagem, $id);
}

$stmt->execute();
$stmt->close();
$conexao->close();

header("Location: admin_table.php");
exit();
?>

<?php
include("conexao.php");

$nome = trim($_POST['nome'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($nome === '' || $senha === '') {
    die("Preencha nome e senha. <a href='cadastro.html'>Voltar</a>");
}

$stmt = $conexao->prepare("SELECT id FROM admin WHERE nome = ?");
$stmt->bind_param("s", $nome);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("Já existe uma conta com esse nome. <a href='login.html'>Fazer login</a>");
}
$stmt->close();

//cripitogra//
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $conexao->prepare("INSERT INTO admin (nome, senha, tipo) VALUES (?, ?, 'usuario')");
$stmt->bind_param("ss", $nome, $senha_hash);

if ($stmt->execute()) {
    echo "<h3>Cadastro feito com sucesso!</h3>";
    echo "<a href='login.html'>Fazer login</a>";
} else {
    echo "Erro ao cadastrar: " . $conexao->error;
}

$stmt->close();
$conexao->close();
?>

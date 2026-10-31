<?php
session_start();
include("conexao.php");

$nome = trim($_POST['nome'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($nome === '' || $senha === '') {
    die("Preencha nome e senha. <a href='login_user.html'>Voltar</a>");
}


$stmt = $conexao->prepare("SELECT id, nome, senha, tipo FROM admin WHERE nome = ?");
$stmt->bind_param("s", $nome);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Usuário não encontrado. <a href='cadastro.html'>Cadastre-se</a>");
}

$usuario = $resultado->fetch_assoc();


if (password_verify($senha, $usuario['senha'])) {


    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['tipo'] = $usuario['tipo'];

    if ($usuario['tipo'] === 'admin') {
        header("Location: admin_table.php");
    } else {
        header("Location: conta.php");
    }
    exit();

} else {
    echo "Senha incorreta. <a href='login.html'>Tentar novamente</a>";
}

$stmt->close();
$conexao->close();
?>

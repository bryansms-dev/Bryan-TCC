<?php
require_once("admin_check.php");
include("conexao.php");

$produto = ["id" => "", "nome" => "", "preco" => "", "preco_antigo" => "", "imagem" => ""];

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conexao->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows > 0) {
        $produto = $resultado->fetch_assoc();
    }
    $stmt->close();
}

$titulo = $produto["id"] === "" ? "Novo Produto" : "Editar Produto";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_table.css?v=2">
    <link rel="stylesheet" href="responsivo.css?v=2">
    <title><?php echo $titulo; ?> - Coffee Tasty</title>
</head>

<body>
    <main class="admin-container">
        <h1><?php echo $titulo; ?></h1>

        <form action="produto_salvar.php" method="POST" class="admin-form">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($produto['id']); ?>">

            <label>Nome</label>
            <input type="text" name="nome" class="input" required
                value="<?php echo htmlspecialchars($produto['nome']); ?>">

            <label>Preço (ex: 12.99)</label>
            <input type="number" step="0.01" name="preco" class="input" required
                value="<?php echo htmlspecialchars($produto['preco']); ?>">

            <label>Preço antigo (opcional, para mostrar riscado)</label>
            <input type="number" step="0.01" name="preco_antigo" class="input"
                value="<?php echo htmlspecialchars($produto['preco_antigo'] ?? ''); ?>">

            <label>Caminho da imagem</label>
            <input type="text" name="imagem" class="input" required placeholder="img/store_img/exemplo.png"
                value="<?php echo htmlspecialchars($produto['imagem']); ?>">

            <div class="admin-form-actions">
                <button class="button">Salvar</button>
                <a href="admin_table.php" class="btn-cancel">Cancelar</a>
            </div>
        </form>
    </main>
</body>

</html>

<?php
require_once("admin_check.php");
include("conexao.php");

$produtos = $conexao->query("SELECT * FROM produtos ORDER BY id");
$usuarios = $conexao->query("SELECT id, nome, tipo FROM admin ORDER BY id");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Orbitron:wght@400..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="admin_table.css?v=2">
    <title>Painel do Administrador - Coffee Tasty</title>
    <script src="menu.js?v=2" defer></script>
</head>

<body>
    <header>
        <div class="logo"> Coffee Tasty </div>
        <nav>
            <ul>
                <li><a href="store.php">Home</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="organograma.php">Organograma</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false">☰</button>
    </header>

    <main class="admin-container">
        <h1>Painel do Administrador</h1>
        <p class="admin-welcome">Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></p>

        <section class="admin-section">
            <div class="admin-section-header">
                <h2>Produtos</h2>
                <a href="editar_produto.php" class="btn-add">+ Novo Produto</a>
            </div>

            <div class="table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Preço Antigo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($p = $produtos->fetch_assoc()): ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($p['imagem']); ?>" class="admin-thumb" alt="<?php echo htmlspecialchars($p['nome']); ?>"></td>
                            <td><?php echo htmlspecialchars($p['nome']); ?></td>
                            <td>R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo $p['preco_antigo'] !== null ? "R$ " . number_format($p['preco_antigo'], 2, ',', '.') : "-"; ?></td>
                            <td>
                                <div class="admin-actions-wrap">
                                    <a href="editar_produto.php?id=<?php echo $p['id']; ?>" class="btn-edit">Editar</a>
                                    <a href="produto_excluir.php?id=<?php echo $p['id']; ?>" class="btn-delete"
                                        onclick="return confirm('Excluir este produto?');">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            </div>
        </section>

        <section class="admin-section">
            <h2>Usuários Cadastrados</h2>

            <div class="table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($u = $usuarios->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $u['id']; ?></td>
                            <td><?php echo htmlspecialchars($u['nome']); ?></td>
                            <td><?php echo $u['tipo'] === 'admin' ? 'Admin' : 'Usuário'; ?></td>
                            <td>
                                <?php if ((int) $u['id'] !== (int) $_SESSION['usuario_id']): ?>
                                    <div class="admin-actions-wrap">
                                        <a href="usuario_promover.php?id=<?php echo $u['id']; ?>" class="btn-edit">
                                            <?php echo $u['tipo'] === 'admin' ? 'Rebaixar' : 'Tornar admin'; ?>
                                        </a>
                                        <a href="usuario_excluir.php?id=<?php echo $u['id']; ?>" class="btn-delete"
                                            onclick="return confirm('Excluir este usuário?');">Excluir</a>
                                    </div>
                                <?php else: ?>
                                    <em>Você</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            </div>
        </section>
    </main>
</body>

</html>
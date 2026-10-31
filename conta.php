<?php
require_once("auth_check.php");
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
    <link rel="stylesheet" href="organograma_2.css?v=2">
    <title>Minha Conta - Coffee Tasty</title>
    <script src="menu.js?v=2" defer></script>
</head>

<body>
    <header>
        <div class="logo"> Coffee Tasty </div>
        <nav>
            <ul>
                <li><a href="store.php">Home</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false">☰</button>
    </header>

    <main class="org-container">
        <h1 class="org-title">Olá, <span><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span></h1>
        <p class="org-subtitle">
            Bem-vindo(a) à sua conta na Coffee Tasty! Por aqui você pode navegar pelo cardápio e fazer seus pedidos.
        </p>

        <a href="produtos.php" class="btn" style="text-decoration:none; display:inline-block;">Ver Cardápio</a>
    </main>
</body>

</html>

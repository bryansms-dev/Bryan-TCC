<?php
session_start();
include("conexao.php");
$produtos = $conexao->query("SELECT * FROM produtos ORDER BY id");
$logado = isset($_SESSION['usuario_id']);
$is_admin = ($_SESSION['tipo'] ?? '') === 'admin';
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
    <link rel="stylesheet" href="responsivo.css?v=2">
    <title>Organograma</title>
    <script src="menu.js?v=2" defer></script>
</head>

<body>
    <header>
        <div class="logo"> Coffee Tasty </div>
        <nav>
            <ul>
                <li><a href="store.php">Home</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="organograma.php" class="current">Organograma</a></li>
                <li><a href="https://api.whatsapp.com/send/?phone=5531996979344">Contato</a> </li>
                <?php if ($logado): ?>
                <?php if ($is_admin): ?>
                    <li><a href="admin_table.php">Painel Admin</a></li>
                <?php endif; ?>
                    <li><a href="logout.php">Sair</a></li>
                <?php else: ?>
                    <li><a href="login.html">Entrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false">☰</button>
    </header>

    <main class="org-container">
        <h1 class="org-title">Organograma da <span>Coffee Tasty</span></h1>
        <p class="org-subtitle">
            Aqui você pode conhecer melhor como a Coffee Tasty funciona por dentro. Cada área possui uma função
            importante para que tudo aconteça da melhor forma, desde o atendimento até o preparo dos produtos, controle
            do estoque, financeiro e divulgação da nossa marca.

            Como somos uma microempresa, todas essas funções são realizadas por uma única pessoa, que assume diferentes
            responsabilidades no dia a dia. Clique em cada cargo para descobrir um pouco mais sobre suas atividades.
        </p>

        <div class="org-chart">
            <div class="org-node root"
                data-desc="Responsável por toda a visão, decisões e direção do negócio — planejamento, metas, relacionamento com fornecedores e clientes, e a supervisão direta de todas as áreas abaixo.">
                <div class="org-card">
                    <img src="img/store_img/admin.png">
                    <h3>Fundador(a) / Responsável Geral</h3>
                </div>
                <div class="org-desc"></div>
            </div>

            <div class="org-branches">
                <div class="org-node"
                    data-desc="Recepção dos clientes, anotação e preparo de pedidos, resolução de dúvidas e reclamações, e garantia de uma boa experiência de compra — atendimento feito pelo site.">
                    <div class="org-card">
                        <img src="img/store_img/atend-cliente.png">
                        <h3>Atendimento ao Cliente</h3>
                    </div>
                    <div class="org-desc"></div>
                </div>

                <div class="org-node"
                    data-desc="Preparo dos cafés e produtos do cardápio, controle de qualidade, padronização das receitas e organização do espaço de produção.">
                    <div class="org-card">
                        <img src="img/store_img/production.png">
                        <h3>Produção / Preparo</h3>
                    </div>
                    <div class="org-desc"></div>
                </div>

                <div class="org-node"
                    data-desc="Compra de insumos e ingredientes, negociação com fornecedores, controle de validade e organização do estoque para evitar falta ou desperdício.">
                    <div class="org-card">
                        <img width="90" height="90" src="img/store_img/box.png">
                        <h3>Compras e Estoque</h3>
                    </div>
                    <div class="org-desc"></div>
                </div>

                <div class="org-node"
                    data-desc="Controle de entradas e saídas, precificação dos produtos, emissão de recibos, e acompanhamento da saúde financeira do negócio.">
                    <div class="org-card">
                        <img src="img/store_img/cash.png">
                        <h3>Financeiro</h3>
                    </div>
                    <div class="org-desc"></div>
                </div>

                <div class="org-node"
                    data-desc="Criação de conteúdo para redes sociais, divulgação de promoções e novos produtos, e construção da identidade visual da marca.">
                    <div class="org-card">
                        <img src="img/store_img/marketing.png">
                        <h3>Marketing e Redes Sociais</h3>
                    </div>
                    <div class="org-desc"></div>
                </div>

            </div>
        </div>
        </div>
    </main>

    <script src="organograma.js" defer></script>
</body>

</html>
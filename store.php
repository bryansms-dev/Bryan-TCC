<?php
session_start();
// ngrok http 80  
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
    <link rel="stylesheet" href="store_2.css?v=2">
    <link rel="stylesheet" href="responsivo.css?v=2">
    <title> Coffee Tasty </title>
    <script src="menu.js?v=2" defer></script>   
</head>

<body>
    <header>
        <div class="logo"> Coffee Tasty </div>
        <nav>
            <ul>
                <li><a href="store.php" class="current">Home</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="organograma.php">Organograma</a></li>
                <li><a href="https://api.whatsapp.com/send/?phone=5531996979344">Contato</a></li>
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

    <main class="container">
        <div class="tech-circle">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
        </div>


        <div class="list">
            <div class="item active">
                <div class="product-img">
                    <img src="img/store_img/starbucks.png" alt="Apple Watch">
                </div>
                <div class="content">
                    <p class="product-tag">Sabor das Nuvens</p>
                    <p class="product-name"> Coffee with chantilly</p>
                    <p class="description">Se você gosta de café e também não dispensa um docinho, essa é a escolha
                        certa! Café saboroso, uma generosa camada de chantilly e pedacinhos de chocolate para deixar
                        cada gole ainda mais especial.</p>


                    <a href="login.html" class="btn"> Saiba Mais </a>

                    
                </div>
            </div>


            <div class="item">
                <div class="product-img">
                    <img src="img/store_img/coffee-choco.png" alt="Air Pods Pro-Max">
                </div>
                <div class="content">
                    <p class="product-tag">Refrescância Viciante</p>
                    <p class="product-name">Ice Coffee</p>
                    <p class="description">E Para os dias quentes, nada melhor que um café bem geladinho! Uma mistura
                        deliciosa de café, gelo e muito sabor, feita para refrescar e dar aquele toque de energia que
                        você precisa.</p>
                    <a href="login.html" class="btn"> Saiba Mais </a>
                </div>
            </div>


            <div class="item">
                <div class="product-img">
                    <img src="img/store_img/caputtino.png" alt="Cappuccino">
                </div>
                <div class="content">
                    <p class="product-tag">Alta Cremosidade</p>
                    <p class="product-name">Cappuccino</p>
                    <p class="description">Cremoso, quentinho e preparado para deixar seu dia ainda mais gostoso! Nosso
                        cappuccino combina café e uma espuma supercremosa, perfeito para acompanhar aquele momento de
                        descanso.</p>
                    <a href="login.html" class="btn"> Saiba Mais </a>
                </div>
            </div>


        </div>

        <div class="arrows">
            <button class="arrow-btn" id="prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-caret-left-fill"
                    viewBox="0 0 16 16">
                    <path
                        d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z" />
                </svg>
            </button>
            <button class="arrow-btn" id="next">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                    class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                    <path
                        d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                </svg>
            </button>
        </div>

        <div class="indicators">
            <div class="numbers">01</div>
            <div class="dots">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </main>
</body>
<script src="./store.js"></script>

</html>

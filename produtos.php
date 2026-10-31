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
    <title>Tasty Produtos</title>
    <link rel="stylesheet" href="produtos.css?v=2" />
    <link rel="stylesheet" href="responsivo.css?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Orbitron:wght@400..900&display=swap"
        rel="stylesheet">

    <script src="produtos.js?v=2" defer></script>
    <script src="menu.js?v=2" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>
</head>

<body>

    <header>
        <div class="logo"> Coffee Tasty </div>
        <nav>
            <ul>
                <li><a href="store.php">Home</a></li>
                <li><a href="produtos.php" class="current">Produtos</a></li>
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

        <div class="icons">
            <button class="cart-button" id="cartButton" type="button" aria-label="Abrir carrinho">
                <img width="30" height="30" class="iconscart" src="img/store_img/cart.png" alt="cart">
                <span class="cart-count" id="cartCount">0</span>
            </button>
        </div>
        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false">☰</button>
    </header>

    <section class="menu" id="menu">
        <h2 class="title"> </h2>

        <div class="box-container">
            <?php while ($produto = $produtos->fetch_assoc()): ?>
                <div class="box">
                    <img src="<?php echo htmlspecialchars($produto['imagem']); ?>"
                        alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                    <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                    <div class="price">
                        R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                        <?php if ($produto['preco_antigo'] !== null): ?>
                            <span>R$<?php echo number_format($produto['preco_antigo'], 2, ',', '.'); ?></span>
                        <?php endif; ?>
                    </div>
                    <a href="#" class="btn add-to-cart"
                        data-name="<?php echo htmlspecialchars($produto['nome']); ?>"
                        data-price="<?php echo $produto['preco']; ?>"
                        data-image="<?php echo htmlspecialchars($produto['imagem']); ?>"> Adicione ao Carrinho </a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <div class="cart-overlay" id="cartOverlay"></div>

    <aside class="cart-sidebar" id="cartSidebar" aria-hidden="true">
        <div class="cart-header">
            <div>
                <h2>Meu Carrinho</h2>
                <span id="cartItemsLabel">0 itens</span>
            </div>
            <button class="cart-close" id="cartClose" type="button" aria-label="Fechar carrinho">&times;</button>
        </div>

        <div class="cart-items" id="cartItems">
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h3>Seu carrinho está vazio</h3>
                <p>Adicione algum produto para começar sua compra.</p>
            </div>
        </div>

        <div class="cart-footer">
            <div class="cart-total">
                <span>Total</span>
                <strong id="cartTotal">R$ 0,00</strong>
            </div>
            <button class="clear-cart" id="clearCart" type="button"> 🗑️ Excluir todos os itens </button>
            <button class="checkout-button" id="checkoutButton" type="button" disabled> Concluir compra </button>
        </div>

    </aside>

    <div class="cart-toast" id="cartToast" role="status" aria-live="polite"></div>

    <div class="pix-overlay" id="pixOverlay">
        <div class="pix-modal">
            <button class="pix-close" id="pixClose" type="button" aria-label="Fechar pagamento">&times;</button>
            <h2>Pagamento via Pix</h2>
            <p class="pix-instrucao">Escaneie o QR Code abaixo com o app do seu banco</p>
            <div id="qrcodePix"></div>
            <div class="pix-valor">
                <span>Valor a pagar</span>
                <strong id="pixValor">R$ 0,00</strong>
            </div>
            <div class="pix-copia">
                <p class="pix-ou">Está pagando pelo celular? Copie o código Pix:</p>
                <textarea id="pixCodigo" class="pix-codigo" rows="4" readonly></textarea>
                <button id="pixCopiar" type="button" class="checkout-button pix-copiar">Copiar código Pix</button>
                <small class="pix-dica">No app do seu banco, abra Pix, escolha "Pix Copia e Cola" e cole o código.</small>
            </div>
        </div>
    </div>

</body>

</html>

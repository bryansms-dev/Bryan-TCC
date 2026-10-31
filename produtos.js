const cart = [];
        const $ = id => document.getElementById(id);

        const cartButton = $("cartButton");
        const cartSidebar = $("cartSidebar");
        const cartOverlay = $("cartOverlay");
        const cartClose = $("cartClose");
        const cartItems = $("cartItems");
        const cartCount = $("cartCount");
        const cartItemsLabel = $("cartItemsLabel");
        const cartTotal = $("cartTotal");
        const clearCartButton = $("clearCart");
        const checkoutButton = $("checkoutButton");
        const cartToast = $("cartToast");

        function formatPrice(value) {
            return value.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
        }

        function quantityTotal() {
            return cart.reduce((sum, item) => sum + item.quantity, 0);
        }

        function showToast(message) {
            cartToast.textContent = message;
            cartToast.classList.add("show");
            clearTimeout(window.toastTimer);
            window.toastTimer = setTimeout(() => cartToast.classList.remove("show"), 2200);
        }

        function openCart() {
            cartSidebar.classList.add("open");
            cartOverlay.classList.add("show");
            cartSidebar.setAttribute("aria-hidden", "false");
            document.body.classList.add("cart-open");
        }

        function closeCart() {
            cartSidebar.classList.remove("open");
            cartOverlay.classList.remove("show");
            cartSidebar.setAttribute("aria-hidden", "true");
            document.body.classList.remove("cart-open");
        }

        function addToCart(name, price, image) {
            const item = cart.find(product => product.name === name);
            if (item) item.quantity++;
            else cart.push({ name, price, image, quantity: 1 });
            renderCart();
            showToast(`${name} foi adicionado ao carrinho!`);
        }

        function changeQuantity(name, amount) {
            const item = cart.find(product => product.name === name);
            if (!item) return;
            item.quantity += amount;
            if (item.quantity <= 0) {
                removeFromCart(name);
                return;
            }
            renderCart();
        }

        function removeFromCart(name) {
            const index = cart.findIndex(product => product.name === name);
            if (index === -1) return;
            cart.splice(index, 1);
            renderCart();
            showToast("Produto removido do carrinho.");
        }

        function clearCart() {
            if (!cart.length) return;
            cart.length = 0;
            renderCart();
            showToast("Carrinho limpo.");
        }

        function renderCart() {
            const quantity = quantityTotal();
            cartCount.textContent = quantity;
            cartCount.classList.toggle("visible", quantity > 0);
            cartItemsLabel.textContent = quantity === 1 ? "1 item" : `${quantity} itens`;

            const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
            cartTotal.textContent = formatPrice(total);

            clearCartButton.disabled = cart.length === 0;
            checkoutButton.disabled = cart.length === 0;

            if (!cart.length) {
                cartItems.innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-cart-icon">🛒</div>
                        <h3>Seu carrinho está vazio</h3>
                        <p>Adicione algum produto para começar sua compra.</p>
                    </div>`;
                return;
            }

            cartItems.innerHTML = cart.map(item => `
                <div class="cart-item">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="cart-item-info">
                        <h3>${item.name}</h3>
                        <span class="cart-item-price">${formatPrice(item.price)}</span>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn" data-action="decrease" data-name="${item.name}">−</button>
                            <span>${item.quantity}</span>
                            <button type="button" class="quantity-btn" data-action="increase" data-name="${item.name}">+</button>
                        </div>
                    </div>
                    <button type="button" class="remove-item" data-action="remove" data-name="${item.name}" aria-label="Remover ${item.name}">🗑️</button>
                </div>
            `).join("");
        }

        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", event => {
                event.preventDefault();
                addToCart(button.dataset.name, Number(button.dataset.price), button.dataset.image);
            });
        });

        cartButton.addEventListener("click", openCart);
        cartClose.addEventListener("click", closeCart);
        cartOverlay.addEventListener("click", closeCart);
        clearCartButton.addEventListener("click", clearCart);

        cartItems.addEventListener("click", event => {
            const button = event.target.closest("button[data-action]");
            if (!button) return;
            const name = button.dataset.name;
            if (button.dataset.action === "increase") changeQuantity(name, 1);
            if (button.dataset.action === "decrease") changeQuantity(name, -1);
            if (button.dataset.action === "remove") removeFromCart(name);
        });

        checkoutButton.addEventListener("click", () => {
            if (!cart.length) return;
            const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
            abrirModalPix(total);
        });

        document.addEventListener("keydown", event => {
            if (event.key === "Escape") {
                closeCart();
                fecharModalPix();
            }
        });

        renderCart();


         // ===== PIX QR CODE ===== //
        function crc16(payload) {
            let crc = 0xFFFF;
            for (let i = 0; i < payload.length; i++) {
                crc ^= payload.charCodeAt(i) << 8;
                for (let j = 0; j < 8; j++) {
                    crc = (crc & 0x8000) ? ((crc << 1) ^ 0x1021) : (crc << 1);
                    crc &= 0xFFFF;
                }
            }
            return crc.toString(16).toUpperCase().padStart(4, "0");
        }

        function gerarPayloadPix(valorTotal) {
            const chave = "12804373673";
            const nome = "CAFETERIA TASTY";
            const cidade = "IPATINGA";
            const valor = valorTotal.toFixed(2); // ex: "23.98"

            const merchantAccount = `0014br.gov.bcb.pix01${String(chave.length).padStart(2, "0")}${chave}`;

            let payload =
                "000201" +                                              // Payload Format Indicator
                `26${String(merchantAccount.length).padStart(2, "0")}${merchantAccount}` +
                "52040000" +                                             // Categoria
                "5303986" +                                              // Moeda BRL
                `54${String(valor.length).padStart(2, "0")}${valor}` +   // Valor dinâmico
                "5802BR" +                                               // País
                `59${String(nome.length).padStart(2, "0")}${nome}` +
                `60${String(cidade.length).padStart(2, "0")}${cidade}` +
                "62070503***" +                                          // Identificador genérico
                "6304";                                                  // Abre o campo do CRC

            return payload + crc16(payload);
        }

        function gerarQRCodePix(valorTotal) {
    const payload = gerarPayloadPix(valorTotal);

    // Esse código remove o QR anterior para não duplicar o QR //
    const container = document.getElementById("qrcodePix");
    container.innerHTML = "";

    new QRCode(container, {
        text: payload,
        width: 220,
        height: 220,
        colorDark: "#000000",
        colorLight: "#ffffff"
    });
}

const pixOverlay = $("pixOverlay");
const pixClose = $("pixClose");
const pixValor = $("pixValor");
const pixCodigo = $("pixCodigo");
const pixCopiar = $("pixCopiar");

function abrirModalPix(valorTotal) {
    pixCodigo.value = gerarPayloadPix(valorTotal);   // 1) código Copia e Cola (mesmo texto do QR)
    pixValor.textContent = formatPrice(valorTotal);  // 2) valor na tela
    pixOverlay.classList.add("show");                // 3) abre o modal
    gerarQRCodePix(valorTotal);                      // 4) QR por último
}

function fecharModalPix() {
    pixOverlay.classList.remove("show");
}

pixClose.addEventListener("click", fecharModalPix);
pixOverlay.addEventListener("click", event => {
    if (event.target === pixOverlay) fecharModalPix();
});


// ===== COPIAR O CÓDIGO PIX =====
let copiadoTimer;

async function copiarCodigoPix() {
    const texto = pixCodigo.value;
    let ok = false;

    try {
        if (navigator.clipboard && window.isSecureContext) {
            // jeito moderno (só funciona em HTTPS ou localhost)
            await navigator.clipboard.writeText(texto);
            ok = true;
        } else {
            // plano B para HTTP comum (ex: testar no celular pelo IP do computador)
            pixCodigo.focus();
            pixCodigo.select();
            pixCodigo.setSelectionRange(0, texto.length);
            ok = document.execCommand("copy");
        }
    } catch (erro) {
        ok = false;
    }

    pixCopiar.textContent = ok ? "Copiado! ✔" : "Segure no código para copiar";
    clearTimeout(copiadoTimer);
    copiadoTimer = setTimeout(() => {
        pixCopiar.textContent = "Copiar código Pix";
    }, 2500);
}

pixCopiar.addEventListener("click", copiarCodigoPix);
pixCodigo.addEventListener("focus", () => pixCodigo.select());
(function () {
    const botao = document.querySelector(".menu-toggle");
    const nav = document.querySelector("header nav");

    // se a página não tiver o botão ou o menu, não faz nd
    if (!botao || !nav) return;

    function abrirMenu() {
        nav.classList.add("open");
        botao.setAttribute("aria-expanded", "true");
        botao.setAttribute("aria-label", "Fechar menu");
        botao.textContent = "✕";
    }

    function fecharMenu() {
        nav.classList.remove("open");
        botao.setAttribute("aria-expanded", "false");
        botao.setAttribute("aria-label", "Abrir menu");
        botao.textContent = "☰";
    }

    // abre se tiver fechedo e fecha se tiver abrto
    botao.addEventListener("click", () => {
        if (nav.classList.contains("open")) {
            fecharMenu();
        } else {
            abrirMenu();
        }
    });

    // ir para outra pgna do header fecha o menu tmb
    nav.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", fecharMenu);
    });

    // "esc" fecha o menu tmb
    document.addEventListener("keydown", evento => {
        if (evento.key === "Escape") fecharMenu();
    });

    // se a janela voltar a ficar largr por ex girar o celular o menu fecha 
    window.addEventListener("resize", () => {
        if (window.innerWidth > 900) fecharMenu();
    });
})();

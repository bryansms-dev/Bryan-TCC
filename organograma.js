// busca a informção que esta no html para adicionar ao slide //
const nodes = document.querySelectorAll(".org-node");
// ESSA SETINHA SIGINIFICA "FUNCTION"//
nodes.forEach(node => {
    const descBox = node.querySelector(".org-desc");
    descBox.textContent = node.dataset.desc;
});

// adiciona o efeito de "silde" //
nodes.forEach((node, index) => {
    setTimeout(() => {
        node.classList.add("show");
    }, index * 150);
});

// abre e fecha o slide e se algum tiver aberto ele fecha tmb //
nodes.forEach(node => {
    const card = node.querySelector(".org-card");

    card.addEventListener("click", () => {
        const isOpen = node.classList.contains("open");

        nodes.forEach(n => n.classList.remove("open"));

        if (!isOpen) {
            node.classList.add("open");
        }
    });
});

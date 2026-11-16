
function alerta(tipo, mensagem) {
    const cores = {
        sucesso: "#198754",
        erro: "#dc3545",
        aviso: "#ffc107",
        info: "#0d6efd"
    };

    const notificacao = document.createElement("div");

    notificacao.className = "notificacao";
    notificacao.style.background = cores[tipo] || cores.info;
    notificacao.textContent = mensagem;

    document.body.appendChild(notificacao);

    setTimeout(() => {
        notificacao.classList.add("saindo");

        setTimeout(() => notificacao.remove(), 300);
    }, 3500);
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-alerta]").forEach(elemento => {
        alerta(
            elemento.dataset.tipo || "info",
            elemento.dataset.alerta
        );
    });
});

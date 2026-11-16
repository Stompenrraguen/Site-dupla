document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-aviso]").forEach((aviso) => {
        const fechar = aviso.querySelector(".aviso-fechar");

        if (fechar) {
            fechar.addEventListener("click", () => aviso.remove());
        }

        window.setTimeout(() => aviso.classList.add("aviso-oculto"), 5500);
        window.setTimeout(() => aviso.remove(), 6000);
    });
});

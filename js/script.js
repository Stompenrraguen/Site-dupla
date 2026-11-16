
(() => {
    "use strict";

    const TEMPO_ALERTA = 5000;

    
    function mostrarAlerta(mensagem, tipo = "sucesso", tempo = TEMPO_ALERTA) {

        if (!mensagem) {
            return;
        }

        const alerta = document.createElement("div");
        alerta.className = `alerta ${tipo}`;

        alerta.setAttribute(
            "role",
            tipo === "erro" ? "alert" : "status"
        );

        alerta.setAttribute("aria-live", "polite");

        const texto = document.createElement("span");
        texto.textContent = mensagem;

        const fechar = document.createElement("button");
        fechar.type = "button";
        fechar.className = "alerta-fechar";
        fechar.textContent = "×";
        fechar.setAttribute("aria-label", "Fechar mensagem");

        fechar.addEventListener("click", () => {
            alerta.remove();
        });

        alerta.appendChild(texto);
        alerta.appendChild(fechar);

        const local =
            document.querySelector(".caixa-formulario") ||
            document.querySelector(".conteudo-principal") ||
            document.querySelector("main") ||
            document.body;

        local.prepend(alerta);

        if (tempo > 0) {
            setTimeout(() => {
                alerta.remove();
            }, tempo);
        }
    }

    
    window.mostrarAlerta = mostrarAlerta;

    
    document.addEventListener("click", (evento) => {

        const fechar = evento.target.closest("[data-fechar-alerta]");

        if (fechar) {
            const alerta = fechar.closest(".alerta");

            if (alerta) {
                alerta.remove();
            }
        }

        const confirmar = evento.target.closest("[data-confirm]");

        if (confirmar) {

            const mensagem =
                confirmar.dataset.confirm ||
                "Deseja realmente continuar?";

            if (!window.confirm(mensagem)) {
                evento.preventDefault();
            }
        }
    });

    
    document.addEventListener("submit", (evento) => {

        const formulario = evento.target;

        if (!(formulario instanceof HTMLFormElement)) {
            return;
        }

        if (formulario.dataset.enviando === "1") {
            evento.preventDefault();
            return;
        }

        formulario.dataset.enviando = "1";
        formulario.setAttribute("aria-busy", "true");
    });

    
    document.addEventListener("DOMContentLoaded", () => {

        document.querySelectorAll(".alerta").forEach((alerta) => {

            setTimeout(() => {
                alerta.remove();
            }, TEMPO_ALERTA);

        });

    });

})();

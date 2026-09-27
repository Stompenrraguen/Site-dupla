<?php

if (!isset($_SESSION)) {
    session_start();
}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Sobre - PoubreSteam</title>

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>


<body>


<header class="topo">

    <nav class="menu">

        <a href="index.php" class="logo">

            <img
                src="img/steam-logo.png"
                alt="Logo PoubreSteam"
            >

            <span>PoubreSteam</span>

        </a>

        <a href="index.php">
            Loja
        </a>

        <a href="produtos.php">
            Produtos
        </a>

        <a href="carrinho.php">
            Carrinho
        </a>

        <a href="biblioteca.php">
            Biblioteca
        </a>

        <a href="sobre.php">
            Sobre
        </a>


        <?php if (!empty($_SESSION["logado"])) { ?>

            <a href="logout.php">
                Sair
            </a>

        <?php } else { ?>

            <a href="login.php">
                Entrar
            </a>

        <?php } ?>

    </nav>

</header>



<main class="sobre">


    <!-- APRESENTAÇÃO -->

    <section class="sobre-inicio">

        <div class="sobre-inicio-texto">

            <h1>
                PoubreSteam
            </h1>

            <h2>
                Sua loja de jogos digitais.
            </h2>

            <p>
                Encontre jogos, monte sua biblioteca e descubra
                novas aventuras em um só lugar.
            </p>

            <a
                href="produtos.php"
                class="botao"
            >
                Explorar jogos
            </a>

        </div>


        <div class="sobre-inicio-logo">

            <img
                src="img/steam-logo.png"
                alt="PoubreSteam"
            >

        </div>

    </section>



    <!-- SOBRE A LOJA -->

    <section class="sobre-bloco">

        <div class="sobre-texto">

            <h2>
                Jogos para todos os gostos
            </h2>

            <p>
                A PoubreSteam é uma loja digital criada para
                reunir diferentes tipos de jogos em um ambiente
                simples e fácil de utilizar.
            </p>

            <p>
                Explore nosso catálogo, veja informações sobre
                cada jogo e encontre aquele que combina com você.
            </p>

        </div>

    </section>



    <!-- BIBLIOTECA -->

    <section class="sobre-bloco sobre-destaque">

        <div class="sobre-texto">

            <h2>
                Sua biblioteca em um só lugar
            </h2>

            <p>
                Depois de realizar uma compra, seus jogos ficam
                disponíveis na sua biblioteca pessoal.
            </p>

            <p>
                Assim, você pode consultar facilmente todos os
                títulos adquiridos através da sua conta.
            </p>

            <a
                href="biblioteca.php"
                class="botao"
            >
                Ver biblioteca
            </a>

        </div>

    </section>



    <!-- COMO FUNCIONA -->

    <section class="sobre-recursos">

        <h2>
            Tudo que você precisa
        </h2>


        <div class="sobre-recursos-grid">


            <div class="sobre-recurso">

                <h3>
                    Catálogo de jogos
                </h3>

                <p>
                    Navegue pelo catálogo e encontre diferentes
                    gêneros e estilos de jogos.
                </p>

            </div>


            <div class="sobre-recurso">

                <h3>
                    Carrinho
                </h3>

                <p>
                    Adicione os jogos que deseja comprar e confira
                    tudo antes de finalizar o pedido.
                </p>

            </div>


            <div class="sobre-recurso">

                <h3>
                    Biblioteca pessoal
                </h3>

                <p>
                    Os jogos comprados ficam associados à sua
                    conta para você consultar quando quiser.
                </p>

            </div>


            <div class="sobre-recurso">

                <h3>
                    Informações detalhadas
                </h3>

                <p>
                    Consulte gênero, classificação, plataforma,
                    desenvolvedora e outras informações dos jogos.
                </p>

            </div>


        </div>

    </section>



    <!-- FINAL -->

<section class="sobre-final">

<section class="sobre-equipe">

    <h2>Equipe PoubreSteam</h2>

    <p class="sobre-equipe-intro">
        Projeto desenvolvido por:
    </p>


    <div class="sobre-criadores">

        <div class="sobre-criador">

            <h3>Enzo Daniel Oliveira</h3>

            <p>
                Criador e desenvolvedor da PoubreSteam.
            </p>

        </div>


        <div class="sobre-criador">

            <h3>Kaio Silva Carvalho</h3>

            <p>
                Criador e desenvolvedor da PoubreSteam.
            </p>

        </div>

    </div>


    <div class="sobre-suporte">

        <h3>Encontrou algum problema?</h3>

        <p>
            Caso encontre algum erro ou tenha dificuldades
            utilizando a PoubreSteam, entre em contato com
            nossa equipe.
        </p>

        <a
            href="mailto:202413600057@ifba.edu.br?subject=Suporte%20PoubreSteam"
            class="botao"
        >
            Entrar em contato
        </a>

        <p class="sobre-email">
            202413600057@ifba.edu.br
        </p>

    </div>

</section>
</section>


</main>



<footer class="rodape">

    PoubreSteam © 2026 - Loja de jogos

</footer>


</body>

</html>

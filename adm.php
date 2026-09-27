<?php

if (!isset($_SESSION)) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";


if (
    empty($_SESSION["logado"]) ||
    empty($_SESSION["adm"])
) {
    header("Location: index.php");
    exit;
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

    <title>Administrador - PoubreSteam</title>

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>


<body>


<main class="conteudo">


    <section class="titulo-secao">

        <h2>Adicionar novo produto</h2>

    </section>


    <?php if (
        isset($_GET["ok"]) &&
        $_GET["ok"] == "1"
    ) { ?>

        <div class="card mensagem-sucesso">

            <div class="card-conteudo">

                <p>
                    Produto adicionado com sucesso ao banco de dados.
                </p>

            </div>

        </div>

        <br>

    <?php } ?>


    <?php if (isset($_GET["erro"])) { ?>

        <div class="card mensagem-erro">

            <div class="card-conteudo">

                <p>
                    Não foi possível adicionar o produto.
                    Confira os dados e tente novamente.
                </p>

            </div>

        </div>

        <br>

    <?php } ?>


    <form
        action="salvar_produto.php"
        method="post"
        class="form-adm"
    >

        <div class="card">

            <div class="card-conteudo">


                <div class="campo-adm">

                    <label for="nome">
                        Nome do produto
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        required
                    >

                </div>


                <div class="campo-adm">

                    <label for="descricao">
                        Descrição
                    </label>

                    <textarea
                        id="descricao"
                        name="descricao"
                        rows="4"
                        required
                    ></textarea>

                </div>


                <div class="campo-adm">

                    <label for="preco">
                        Preço
                    </label>

                    <input
                        type="number"
                        id="preco"
                        name="preco"
                        step="0.01"
                        min="0"
                        required
                    >

                </div>


                <div class="campo-adm">

                    <label for="imagem">
                        Nome completo do arquivo da imagem
                    </label>

                    <input
                        type="text"
                        id="imagem"
                        name="imagem"
                        placeholder="Ex.: jogo.jpg ou img/jogo.jpg"
                        required
                    >

                    <p class="ajuda-form">
                        Coloque depois o arquivo dentro da pasta
                        <strong>img</strong>.
                        Se informar somente o nome, o sistema acrescentará
                        <strong>img/</strong> automaticamente.
                    </p>

                </div>


                <div class="campo-adm">

                    <label for="desenvolvedora">
                        Desenvolvedora
                    </label>

                    <input
                        type="text"
                        id="desenvolvedora"
                        name="desenvolvedora"
                    >

                </div>


                <div class="campo-adm">

                    <label for="publicadora">
                        Publicadora
                    </label>

                    <input
                        type="text"
                        id="publicadora"
                        name="publicadora"
                    >

                </div>


                <div class="campo-adm">

                    <label for="genero">
                        Gênero
                    </label>

                    <input
                        type="text"
                        id="genero"
                        name="genero"
                    >

                </div>


                <div class="campo-adm">

                    <label for="plataformas">
                        Plataformas
                    </label>

                    <input
                        type="text"
                        id="plataformas"
                        name="plataformas"
                    >

                </div>


                <div class="campo-adm">

                    <label for="tamanho">
                        Tamanho
                    </label>

                    <input
                        type="text"
                        id="tamanho"
                        name="tamanho"
                        placeholder="Ex.: 70 GB"
                    >

                </div>


                <div class="campo-adm">

                    <label for="versao">
                        Versão
                    </label>

                    <input
                        type="text"
                        id="versao"
                        name="versao"
                        placeholder="Ex.: 1.0"
                    >

                </div>


                <div class="campo-adm">

                    <label for="classificacao">
                        Classificação
                    </label>

                    <input
                        type="text"
                        id="classificacao"
                        name="classificacao"
                        placeholder="Ex.: 16 anos"
                    >

                </div>


                <div class="campo-adm">

                    <label for="idiomas">
                        Idiomas
                    </label>

                    <input
                        type="text"
                        id="idiomas"
                        name="idiomas"
                    >

                </div>


                <div class="campo-adm">

                    <label for="modo">
                        Modo
                    </label>

                    <input
                        type="text"
                        id="modo"
                        name="modo"
                    >

                </div>


                <div class="campo-adm">

                    <label for="data_lancamento">
                        Ano de lançamento
                    </label>

                    <input
                        type="number"
                        id="data_lancamento"
                        name="data_lancamento"
                        min="1900"
                        max="2100"
                        placeholder="Ex.: 2026"
                    >

                </div>


                <div class="campo-adm">

                    <label for="licenca">
                        Licença
                    </label>

                    <input
                        type="text"
                        id="licenca"
                        name="licenca"
                    >

                </div>


                <button
                    type="submit"
                    class="botao"
                >
                    Adicionar produto
                </button>


            </div>

        </div>

    </form>


</main>


<footer class="rodape">

    PoubreSteam © 2026 - Loja de jogos

</footer>


</body>

</html>

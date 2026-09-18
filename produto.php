<?php
if (!isset($_SESSION)) session_start();
include "produtos.php";

$idProduto = (int)($_GET["id"] ?? 0);

if (!isset($produtos[$idProduto])) {
    header("Location: index.php");
    exit;
}

$p = $produtos[$idProduto];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $p["nome"] ?> - PoubreSteam</title>
    <link rel="stylesheet" href="css/style.css?v=4">
</head>

<body>

    <header>
        <h1>PoubreSteam</h1>

        <nav>
            <a href="index.php">Início</a>
            <a href="carrinho.php">Carrinho</a>

            <?php if (!empty($_SESSION["logado"])): ?>
                <a href="biblioteca.php">Biblioteca</a>
                <a href="logout.php">Sair</a>
            <?php else: ?>
                <a href="login.php">Entrar</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="pagina-produto">

        <a href="index.php" class="voltar-produto">
            ← Voltar para a loja
        </a>

        <section class="produto-cabecalho">

            <div class="produto-imagem-grande">
                <img
                    src="<?= $p["imagem"] ?>"
                    alt="<?= $p["nome"] ?>"
                >
            </div>

            <div class="produto-resumo">

                <h2><?= $p["nome"] ?></h2>

                <p class="produto-descricao">
                    <?= $p["descricao"] ?>
                </p>

                <p class="produto-preco">
                    R$ <?= number_format($p["preco"], 2, ",", ".") ?>
                </p>

                <div class="produto-acoes">

                    <form action="carrinho.php" method="POST">
                        <input
                            type="hidden"
                            name="produto_id"
                            value="<?= $idProduto ?>"
                        >

                        <button type="submit">
                            Adicionar ao carrinho
                        </button>
                    </form>

                    <form
                        action="<?= !empty($_SESSION["logado"]) ? "confirmar.php" : "login.php" ?>"
                        method="POST"
                    >
                        <input
                            type="hidden"
                            name="produto_id"
                            value="<?= $idProduto ?>"
                        >

                        <button type="submit">
                            Comprar agora
                        </button>
                    </form>

                </div>

            </div>

        </section>

        <section class="informacoes-produto">

            <h2>Informações do produto</h2>

            <div class="grade-informacoes">

                <?php if (isset($p["desenvolvedora"])): ?>
                    <div class="informacao-produto">
                        <strong>Desenvolvedora</strong>
                        <span><?= $p["desenvolvedora"] ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($p["publicadora"])): ?>
                    <div class="informacao-produto">
                        <strong>Publicadora</strong>
                        <span><?= $p["publicadora"] ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($p["genero"])): ?>
                    <div class="informacao-produto">
                        <strong>Gênero</strong>
                        <span><?= $p["genero"] ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($p["plataformas"])): ?>
                    <div class="informacao-produto">
                        <strong>Plataformas</strong>
                        <span><?= $p["plataformas"] ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($p["tamanho"])): ?>
                    <div class="informacao-produto">
                        <strong>Tamanho</strong>
                        <span><?= $p["tamanho"] ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($p["versao"])): ?>
                    <div class="informacao-produto">
                        <strong>Versão</strong>
                        <span><?= $p["versao"] ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($p["classificacao"])): ?>
                    <div class="informacao-produto">
                        <strong>Classificação</strong>
                        <span><?= $p["classificacao"] ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($p["idiomas"])): ?>
                    <div class="informacao-produto">
                        <strong>Idiomas</strong>
                        <span><?= $p["idiomas"] ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($p["modo"])): ?>
                    <div class="informacao-produto">
                        <strong>Modo de jogo</strong>
                        <span><?= $p["modo"] ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($p["data_lancamento"])): ?>
                    <div class="informacao-produto">
                        <strong>Data de lançamento</strong>
                        <span><?= $p["data_lancamento"] ?></span>
                    </div>
                <?php endif; ?>

            </div>

        </section>

        <section class="aviso-revenda">

            <h2>Sobre a comercialização</h2>

            <p>
                Este produto é disponibilizado pela PoubreSteam
                para revenda digital, de acordo com as informações
                apresentadas nesta página.
            </p>

            <?php if (isset($p["licenca"])): ?>
                <p>
                    <strong>Licença:</strong>
                    <?= $p["licenca"] ?>
                </p>
            <?php endif; ?>

        </section>

    </main>

</body>

</html>

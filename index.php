<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

extract($_POST, EXTR_SKIP);
$busca = trim($busca_campo ?? "");

include "produtos.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PoubreSteam - Loja de Jogos</title>
    <link rel="stylesheet" href="css/style.css?v=5">
    <link rel="stylesheet" href="css/avisos.css">
</head>
<body>
<header class="topo">
    <div class="marca">
        <img src="img/steam-logo.png" alt="Logo PoubreSteam" class="logo-site">
        <div>
            <h1>PoubreSteam</h1>
            <p>Loja digital de jogos</p>
        </div>
    </div>

    <nav class="menu-principal">
        <a href="index.php">Loja</a>
        <a href="carrinho.php">Carrinho</a>
        <a href="biblioteca.php">Biblioteca</a>
        <a href="sobre.php">Sobre</a>
    </nav>

    <div class="area-login">
        <?php if (!empty($_SESSION["logado"])): ?>
            <p class="texto-usuario">
                Olá, <?= htmlspecialchars($_SESSION["nome"] ?? "", ENT_QUOTES, "UTF-8") ?>
            </p>
            <a href="logout.php" class="botao-secundario">Sair</a>
        <?php else: ?>
            <a href="login.php" class="botao-secundario">Login</a>
        <?php endif; ?>
    </div>
</header>

<?php include "avisos.php"; ?>

<section class="barra-busca">
    <form action="index.php" method="POST">
        <input
            type="text"
            name="busca_campo"
            placeholder="Pesquisar jogos na loja"
            value="<?= htmlspecialchars($busca, ENT_QUOTES, "UTF-8") ?>">
        <button type="submit" name="b_busca" value="1">Pesquisar</button>
    </form>
</section>

<section class="chamada">
    <div>
        <h2>Promoções da Semana</h2>
        <p>Escolha seu jogo, adicione ao carrinho, faça login e confirme sua compra.</p>
    </div>
</section>

<main class="conteudo-principal">
    <h2 class="titulo-secao">
        <?= $busca !== "" ? "Resultados da busca" : "Jogos em destaque" ?>
    </h2>

    <?php if (empty($produtos)): ?>
        <div class="painel-vazio">
            <h3>Nenhum produto encontrado.</h3>
            <p>Tente outro termo de busca ou volte para a loja.</p>
        </div>
    <?php else: ?>
        <div class="grade-produtos">
            <?php foreach ($produtos as $id => $produto): ?>
                <div class="cartao-produto">
                    <img
                        src="<?= htmlspecialchars($produto["imagem"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                        alt="<?= htmlspecialchars($produto["nome"] ?? "", ENT_QUOTES, "UTF-8") ?>">

                    <div class="conteudo-cartao">
                        <h3><?= htmlspecialchars($produto["nome"] ?? "", ENT_QUOTES, "UTF-8") ?></h3>
                        <p><?= htmlspecialchars($produto["descricao"] ?? "", ENT_QUOTES, "UTF-8") ?></p>

                        <div class="rodape-cartao">
                            <strong>R$ <?= number_format((float)$produto["preco"], 2, ",", ".") ?></strong>

                            <form action="carrinho.php" method="POST">
                                <input type="hidden" name="produto_id" value="<?= (int)$id ?>">
                                <button type="submit" name="b_adicionar" value="1" class="botao-comprar">
                                    Adicionar
                                </button>
                            </form>

                            <form action="confirmar.php" method="POST">
                                <input type="hidden" name="produto_id" value="<?= (int)$id ?>">
                                <button type="submit" name="b_comprar" value="1" class="botao-direto">
                                    Comprar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<footer>
    <strong>PoubreSteam</strong>
    <p>&copy; 2026 PoubreSteam. Todos os direitos reservados.</p>
    <p><strong>Criadores:</strong> Kaio Carvalho, Enzo Daniel e equipe.</p>
</footer>
</body>
</html>

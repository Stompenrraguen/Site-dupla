<?php
if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "SELECT * FROM produto WHERE id_produto = $id";
    $resultado = banco($server, $user, $password, $db, $sql);

    $produto = $resultado->fetch_assoc();

} elseif (isset($_GET["busca"])) {

    $busca = addslashes(trim($_GET["busca"]));

    $sql = "SELECT * FROM produto
            WHERE nome LIKE '%$busca%'
            OR descricao LIKE '%$busca%'
            OR genero LIKE '%$busca%'
            ORDER BY id_produto";

    $resultado = banco($server, $user, $password, $db, $sql);

    $produtos = [];

    while ($produto = $resultado->fetch_assoc()) {
        $produtos[] = $produto;
    }

} else {

    $sql = "SELECT * FROM produto ORDER BY id_produto";
    $resultado = banco($server, $user, $password, $db, $sql);

    $produtos = [];

    while ($produto = $resultado->fetch_assoc()) {
        $produtos[] = $produto;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PoubreSteam - Produtos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="topo">
    <nav class="menu">

        <a href="index.php" class="logo">
            <img src="img/steam-logo.png" alt="Logo PoubreSteam">
                <span>PoubreSteam</span>
        </a>

        <div class="menu-links">
            <a href="index.php">Loja</a>
            <a href="produtos.php">Produtos</a>
            <a href="carrinho.php">Carrinho</a>
            <a href="biblioteca.php">Biblioteca</a>
            <a href="sobre.php">Sobre</a>

            <?php if (!empty($_SESSION["logado"])) { ?>

                <a href="logout.php">Sair</a>

            <?php } else { ?>

                <a href="login.php">Login</a>
                <a href="cadastro1.php">Cadastro</a>

            <?php } ?>
        </div>

        <form class="busca" action="produtos.php" method="get">

            <input
                type="text"
                name="busca"
                placeholder="Buscar na loja"
                value="<?php echo isset($_GET["busca"]) ? htmlspecialchars($_GET["busca"]) : ""; ?>"
            >

            <button type="submit">🔍</button>

        </form>

    </nav>
</header>

<main class="conteudo">

<?php if (isset($_GET["id"]) && !empty($produto)) { ?>

    <?php extract($produto); ?>

    <section class="hero">

        <div class="hero-imagem">
            <img src="<?php echo $imagem; ?>" alt="<?php echo htmlspecialchars($nome); ?>">
        </div>

        <div class="hero-info">

            <h1><?php echo htmlspecialchars($nome); ?></h1>

            <p>
                <?php echo htmlspecialchars($descricao); ?>
            </p>

            <div class="preco">
                R$ <?php echo number_format($preco, 2, ',', '.'); ?>
            </div>

            <a href="carrinho.php?id=<?php echo $id_produto; ?>" class="botao">
                Adicionar ao carrinho
            </a>

        </div>

    </section>

    <section class="titulo-secao">
        <h2>Informações do jogo</h2>
    </section>

    <div class="card">

        <div class="card-conteudo">

            <p><strong>Desenvolvedora:</strong> <?php echo htmlspecialchars($desenvolvedora); ?></p>
            <p><strong>Publicadora:</strong> <?php echo htmlspecialchars($publicadora); ?></p>
            <p><strong>Gênero:</strong> <?php echo htmlspecialchars($genero); ?></p>
            <p><strong>Plataformas:</strong> <?php echo htmlspecialchars($plataformas); ?></p>
            <p><strong>Tamanho:</strong> <?php echo htmlspecialchars($tamanho); ?></p>
            <p><strong>Versão:</strong> <?php echo htmlspecialchars($versao); ?></p>
            <p><strong>Classificação:</strong> <?php echo htmlspecialchars($classificacao); ?></p>
            <p><strong>Idiomas:</strong> <?php echo htmlspecialchars($idiomas); ?></p>
            <p><strong>Modo:</strong> <?php echo htmlspecialchars($modo); ?></p>
            <p><strong>Data de lançamento:</strong> <?php echo htmlspecialchars($data_lancamento); ?></p>
            <p><strong>Licença:</strong> <?php echo htmlspecialchars($licenca); ?></p>

        </div>

    </div>

    <br>

    <a href="produtos.php" class="botao">
        Voltar aos produtos
    </a>

<?php } else { ?>

    <section class="titulo-secao">

        <?php if (isset($_GET["busca"])) { ?>

            <h2>
                Resultados para:
                <?php echo htmlspecialchars($_GET["busca"]); ?>
            </h2>

        <?php } else { ?>

            <h2>Todos os produtos</h2>

        <?php } ?>

    </section>

    <?php if (!empty($produtos)) { ?>

        <div class="produtos">

            <?php foreach ($produtos as $produto) { ?>

                <?php extract($produto); ?>

                <article class="card">

                    <a href="produtos.php?id=<?php echo $id_produto; ?>">

                        <img
                            class="card-imagem"
                            src="<?php echo $imagem; ?>"
                            alt="<?php echo htmlspecialchars($nome); ?>"
                        >

                    </a>

                    <div class="card-conteudo">

                        <h3>
                            <?php echo htmlspecialchars($nome); ?>
                        </h3>

                        <p class="card-descricao">
                            <?php echo htmlspecialchars($descricao); ?>
                        </p>

                        <div class="card-rodape">

                            <span class="card-preco">
                                R$ <?php echo number_format($preco, 2, ',', '.'); ?>
                            </span>

                            <a
                                href="produtos.php?id=<?php echo $id_produto; ?>"
                                class="card-botao"
                            >
                                Ver jogo
                            </a>

                        </div>

                    </div>

                </article>

            <?php } ?>

        </div>

    <?php } else { ?>

        <div class="card">

            <div class="card-conteudo">

                <h3>Nenhum jogo encontrado.</h3>

                <br>

                <p>
                    Não encontramos produtos para essa pesquisa.
                </p>

            </div>

        </div>

    <?php } ?>

<?php } ?>

</main>

<footer class="rodape">
    PoubreSteam © 2026 - Loja de jogos
</footer>

</body>
</html>

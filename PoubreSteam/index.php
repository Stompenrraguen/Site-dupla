
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

// Busca os produtos cadastrados.
$consulta = "SELECT * FROM produto ORDER BY id_produto DESC";

$resultado = banco($server, $user, $password, $db, $consulta);

$produtos = [];

while ($produto = $resultado->fetch_assoc()) {
    $produtos[] = $produto;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>PoubreSteam - Loja de Jogos</title>

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
>

<button type="submit">🔍</button>

</form>

</nav>

</header>

<main class="conteudo">

<?php if (!empty($produtos)) { ?>

<?php
$destaque = $produtos[0];
extract($destaque);
?>

<section class="hero">

<div class="hero-imagem">

<img
src="<?php echo htmlspecialchars($imagem, ENT_QUOTES, "UTF-8"); ?>"
alt="<?php echo htmlspecialchars($nome, ENT_QUOTES, "UTF-8"); ?>"
>

</div>

<div class="hero-info">

<h1>
<?php echo htmlspecialchars($nome); ?>
</h1>

<p>
<?php echo htmlspecialchars($descricao); ?>
</p>

<div class="preco">

R$ <?php echo number_format($preco, 2, ',', '.'); ?>

</div>

<a
href="produtos.php?id=<?php echo (int)$id_produto; ?>"
class="botao"
>
Ver detalhes
</a>

</div>

</section>

<?php } ?>

<section>

<div class="titulo-secao">

<h2>Lançamentos populares</h2>

</div>

<div class="produtos">

<?php if (!empty($produtos)) { ?>

<?php foreach ($produtos as $produto) { ?>

<?php extract($produto); ?>

<article class="card">

<a href="produtos.php?id=<?php echo (int)$id_produto; ?>">

<img
class="card-imagem"
src="<?php echo htmlspecialchars($imagem, ENT_QUOTES, "UTF-8"); ?>"
alt="<?php echo htmlspecialchars($nome, ENT_QUOTES, "UTF-8"); ?>"
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
href="produtos.php?id=<?php echo (int)$id_produto; ?>"
class="card-botao"
>
Ver jogo
</a>

</div>

</div>

</article>

<?php } ?>

<?php } else { ?>

<p>
Nenhum jogo cadastrado no momento.
</p>

<?php } ?>

</div>

</section>

</main>

<footer class="rodape">

PoubreSteam © 2026 - Loja de jogos

</footer>

</body>
</html>

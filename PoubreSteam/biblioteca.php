
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";

// Verifica se o usuário está logado.
if (empty($_SESSION["logado"])) {
    header("Location: login.php");
    exit;
}

// Impede o acesso do administrador à biblioteca de clientes.
$id_usuario = (int)($_SESSION["id_usuario"] ?? 0);

if ($id_usuario <= 0) {
    header("Location: index.php");
    exit;
}

// Busca os jogos comprados pelo usuário.
$consulta = "SELECT vendas.numero_venda,
                    vendas.quantidade,
                    vendas.valor_unitario,
                    vendas.valor_total,
                    vendas.forma_pagamento,
                    vendas.data_hora,
                    produto.nome,
                    produto.descricao,
                    produto.imagem
             FROM vendas
             INNER JOIN produto
             ON vendas.id_produto = produto.id_produto
             WHERE vendas.id_usuario = '$id_usuario'
             ORDER BY vendas.data_hora DESC";

$resultado = banco($server, $user, $password, $db, $consulta);

$compras = [];

while ($compra = $resultado->fetch_assoc()) {
    $compras[] = $compra;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Minha Biblioteca - PoubreSteam</title>

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
<a href="logout.php">Sair</a>

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

<section class="titulo-secao">

<h2>Minha Biblioteca</h2>

</section>

<?php if (isset($_GET["compra"]) && $_GET["compra"] === "ok") { ?>

<div class="card mensagem-sucesso">

<div class="card-conteudo">

<p>
Compra registrada com sucesso! Seus jogos estão na biblioteca.
</p>

</div>

</div>

<br>

<?php } ?>

<?php if (!empty($compras)) { ?>

<div class="produtos">

<?php foreach ($compras as $compra) { ?>

<?php extract($compra); ?>

<article class="card">

<?php if (!empty($imagem)) { ?>

<img
class="card-imagem"
src="<?php echo htmlspecialchars($imagem, ENT_QUOTES, "UTF-8"); ?>"
alt="<?php echo htmlspecialchars($nome, ENT_QUOTES, "UTF-8"); ?>"
>

<?php } ?>

<div class="card-conteudo">

<h3>
<?php echo htmlspecialchars($nome); ?>
</h3>

<p class="card-descricao">
<?php echo htmlspecialchars($descricao); ?>
</p>

<p>
<strong>Quantidade:</strong>
<?php echo (int)$quantidade; ?>
</p>

<p>
<strong>Valor unitário:</strong>
R$ <?php echo number_format($valor_unitario, 2, ',', '.'); ?>
</p>

<p>
<strong>Total:</strong>
R$ <?php echo number_format($valor_total, 2, ',', '.'); ?>
</p>

<p>
<strong>Forma de pagamento:</strong>
<?php echo htmlspecialchars($forma_pagamento); ?>
</p>

<p>
<strong>Data da compra:</strong>
<?php echo date("d/m/Y H:i", strtotime($data_hora)); ?>
</p>

<p>
<strong>Número da venda:</strong>
<?php echo htmlspecialchars($numero_venda); ?>
</p>

</div>

</article>

<?php } ?>

</div>

<?php } else { ?>

<div class="card">

<div class="card-conteudo">

<h3>Sua biblioteca está vazia.</h3>

<p>
Você ainda não possui jogos comprados.
</p>

<br>

<a href="produtos.php" class="botao">
Explorar jogos
</a>

</div>

</div>

<?php } ?>

</main>

<footer class="rodape">

PoubreSteam © 2026 - Loja de jogos

</footer>

</body>

</html>

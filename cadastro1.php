<?php
if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

if (empty($_SESSION["logado"])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

if (isset($_GET["id"])) {

    $id_produto = (int)$_GET["id"];

    $consulta = "SELECT id_produto
                 FROM produto
                 WHERE id_produto = '$id_produto'";

    $resultado = banco($server, $user, $password, $db, $consulta);

    if ($resultado->num_rows > 0) {

        $consulta = "SELECT id_carrinho
                     FROM carrinho
                     WHERE id_usuario = '$id_usuario'
                     AND id_produto = '$id_produto'";

        $resultado = banco($server, $user, $password, $db, $consulta);

        if ($resultado->num_rows == 0) {

            $consulta = "INSERT INTO carrinho
                         (id_usuario, id_produto, quantidade)
                         VALUES
                         ('$id_usuario', '$id_produto', '1')";

            banco($server, $user, $password, $db, $consulta);
        }
    }

    header("Location: carrinho.php");
    exit;
}

if (isset($_GET["remover"])) {

    $id_carrinho = (int)$_GET["remover"];

    $consulta = "DELETE FROM carrinho
                 WHERE id_carrinho = '$id_carrinho'
                 AND id_usuario = '$id_usuario'";

    banco($server, $user, $password, $db, $consulta);

    header("Location: carrinho.php");
    exit;
}

$consulta = "SELECT carrinho.id_carrinho,
                    carrinho.id_produto,
                    carrinho.quantidade,
                    produto.nome,
                    produto.descricao,
                    produto.preco,
                    produto.imagem
             FROM carrinho
             INNER JOIN produto
             ON carrinho.id_produto = produto.id_produto
             WHERE carrinho.id_usuario = '$id_usuario'
             ORDER BY carrinho.id_carrinho DESC";

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
<title>PoubreSteam - Carrinho</title>
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
<input type="text" name="busca" placeholder="Buscar na loja">
<button type="submit">🔍</button>
</form>

</nav>
</header>

<main class="conteudo">

<section class="titulo-secao">
<h2>Seu carrinho</h2>
</section>

<?php if (!empty($produtos)) { ?>

<div class="produtos">

<?php
$total = 0;

foreach ($produtos as $produto) {
    extract($produto);

    $subtotal = $preco * $quantidade;
    $total += $subtotal;
?>

<article class="card">

<img class="card-imagem"
     src="<?php echo $imagem; ?>"
     alt="<?php echo htmlspecialchars($nome); ?>">

<div class="card-conteudo">

<h3><?php echo htmlspecialchars($nome); ?></h3>

<p class="card-descricao">
<?php echo htmlspecialchars($descricao); ?>
</p>

<p>
Quantidade: <?php echo $quantidade; ?>
</p>

<div class="card-rodape">

<span class="card-preco">
R$ <?php echo number_format($subtotal, 2, ',', '.'); ?>
</span>

<a href="carrinho.php?remover=<?php echo $id_carrinho; ?>"
   class="card-botao">
Remover
</a>

</div>

</div>

</article>

<?php } ?>

</div>

<section class="titulo-secao">
<h2>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h2>

<br>

<a href="confirmar.php" class="botao">
Continuar para compra
</a>
</section>

<?php } else { ?>

<div class="card">
<div class="card-conteudo">
<h3>Seu carrinho está vazio.</h3>
<p>Adicione jogos da loja para comprá-los depois.</p>
<br>
<a href="produtos.php" class="botao">
Ir para a loja
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

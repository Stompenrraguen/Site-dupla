<?php
if (!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

if (empty($_SESSION["logado"])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

$consulta = "SELECT nome, endereco, bairro, cidade, estado, cep
             FROM usuario
             INNER JOIN endereco
             ON usuario.id_usuario = endereco.id_usuario
             WHERE usuario.id_usuario = '$id_usuario'";

$resultado = banco($server, $user, $password, $db, $consulta);

if (!$resultado || $resultado->num_rows == 0) {
    echo "Não foi possível localizar o endereço da sua conta.";
    exit;
}

$dados_usuario = $resultado->fetch_assoc();

extract($dados_usuario);

$nome_usuario = $nome;

$consulta = "SELECT carrinho.id_carrinho,
                    carrinho.id_produto,
                    carrinho.quantidade,
                    produto.nome,
                    produto.preco,
                    produto.imagem
             FROM carrinho
             INNER JOIN produto
             ON carrinho.id_produto = produto.id_produto
             WHERE carrinho.id_usuario = '$id_usuario'
             ORDER BY carrinho.id_carrinho DESC";

$resultado = banco($server, $user, $password, $db, $consulta);

$produtos = [];
$total = 0;

while ($produto = $resultado->fetch_assoc()) {

    $produtos[] = $produto;

    $total += $produto["preco"] * $produto["quantidade"];
}

if (empty($produtos)) {
    header("Location: carrinho.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>PoubreSteam - Confirmar compra</title>

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

<h2>Confirmar compra</h2>

</section>


<div class="card">

<div class="card-conteudo">

<h3>Jogos da compra</h3>

<?php foreach ($produtos as $produto) { ?>

<?php extract($produto); ?>

<p>

<strong>
<?php echo htmlspecialchars($nome); ?>
</strong>

—

<?php echo $quantidade; ?> unidade(s)

—

R$

<?php echo number_format(
    $preco * $quantidade,
    2,
    ',',
    '.'
); ?>

</p>

<?php } ?>

<br>

<h3>

Total:

R$

<?php echo number_format(
    $total,
    2,
    ',',
    '.'
); ?>

</h3>

</div>

</div>


<br>


<div class="card">

<div class="card-conteudo">

<h3>Dados cadastrados</h3>

<p>
<strong>Nome:</strong>
<?php echo htmlspecialchars($nome_usuario); ?>
</p>

<p>
<strong>Endereço:</strong>
<?php echo htmlspecialchars($endereco); ?>
</p>

<p>
<strong>Bairro:</strong>
<?php echo htmlspecialchars($bairro); ?>
</p>

<p>
<strong>Cidade:</strong>
<?php echo htmlspecialchars($cidade); ?>
</p>

<p>
<strong>Estado:</strong>
<?php echo htmlspecialchars($estado); ?>
</p>

<p>
<strong>CEP:</strong>
<?php echo htmlspecialchars($cep); ?>
</p>

</div>

</div>


<br>


<form action="finalizar_compra.php" method="post">

<div class="card">

<div class="card-conteudo">

<h3>Forma de pagamento</h3>

<br>

<label for="forma_pagamento">
Escolha:
</label>

<br>

<select
name="forma_pagamento"
id="forma_pagamento"
required
>

<option value="">
Selecione
</option>

<option value="Pix">
Pix
</option>

<option value="Cartão">
Cartão
</option>

<option value="Boleto">
Boleto
</option>

</select>

<br><br>

<input
type="submit"
value="Finalizar compra"
class="botao"
>

</div>

</div>

</form>

</main>

<footer class="rodape">

PoubreSteam © 2026 - Loja de jogos

</footer>

</body>

</html>

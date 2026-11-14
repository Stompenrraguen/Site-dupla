<?php
if(!isset($_SESSION)) session_start();

include "app/cons.php";
require_once "app/DLL.php";

if(empty($_SESSION["logado"])){
    header("Location: login.php");
    exit;
}

$compras=[];

$consulta="SELECT v.*,p.nome AS nome_produto,p.imagem
FROM vendas v
INNER JOIN usuario u ON v.id_usuario=u.id_usuario
INNER JOIN produto p ON v.id_produto=p.id_produto
WHERE u.cpf='{$_SESSION["cpf"]}'
ORDER BY v.id_venda DESC";

$resultado=banco($server,$user,$password,$db,$consulta);

while($venda=$resultado->fetch_assoc()){
    $compras[]=$venda;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Biblioteca - PoubreSteam</title>
<link rel="stylesheet" href="css/style.css?v=4">
</head>

<body>

<header class="topo">

<div class="marca">
<img src="img/steam-logo.png" alt="Logo" class="logo-site">

<div>
<h1>PoubreSteam</h1>
<p>Biblioteca</p>
</div>

</div>

<nav class="menu-principal">
<a href="index.php">Loja</a>
<a href="carrinho.php">Carrinho</a>
<a href="biblioteca.php">Biblioteca</a>
<a href="sobre.php">Sobre</a>
</nav>

<div class="area-login">
<p class="texto-usuario"><?=htmlspecialchars($_SESSION["nome"])?></p>
<a href="logout.php" class="botao-secundario">Sair</a>
</div>

</header>

<main class="conteudo-principal">

<h2 class="titulo-secao">Sua biblioteca</h2>

<?php if(empty($compras)): ?>

<div class="painel-vazio">
<h3>Nenhuma compra registrada ainda.</h3>
<p>Quando você finalizar uma compra, ela aparecerá aqui.</p>
</div>

<?php else: ?>

<div class="grade-biblioteca">

<?php foreach($compras as $compra): ?>

<div class="cartao-biblioteca">

<img src="<?=htmlspecialchars($compra["imagem"])?>" alt="<?=htmlspecialchars($compra["nome_produto"])?>">

<h3><?=htmlspecialchars($compra["nome_produto"])?></h3>

<p>
<strong>Venda:</strong>
<?=htmlspecialchars($compra["numero_venda"])?>
</p>

<p>
<strong>Quantidade:</strong>
<?=htmlspecialchars($compra["quantidade"])?>
</p>

<p>
<strong>Total:</strong>
R$ <?=number_format($compra["valor_total"],2,",",".")?>
</p>

<p>
<strong>Data:</strong>
<?=htmlspecialchars($compra["data_hora"])?>
</p>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>

</main>

<footer>
<p>PoubreSteam &copy; 2026 - Todos os direitos reservados.</p>
</footer>

</body>
</html>
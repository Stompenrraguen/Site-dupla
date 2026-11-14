<?php
if(!isset($_SESSION)) session_start();

if(empty($_SESSION["logado"])||empty($_SESSION["adm"])){
header("Location: index.php");
exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Administrador - PoubreSteam</title>
<link rel="stylesheet" href="css/style.css?v=4">
</head>
<body>

<header class="topo">
<div class="marca">
<h1>PoubreSteam</h1>
<p>Painel administrativo</p>
</div>

<div class="area-login">
<p class="texto-usuario">Administrador</p>
<a href="logout.php" class="botao-secundario">Sair</a>
</div>
</header>

<main class="conteudo-principal">

<h2 class="titulo-secao">Adicionar novo produto</h2>

<form action="salvar_produto.php" method="POST" enctype="multipart/form-data">

<label>Nome do produto</label>
<input type="text" name="nome" required>

<label>Descrição</label>
<input type="text" name="descricao">

<label>Preço</label>
<input type="number" name="preco" step="0.01" min="0" required>

<label>Imagem</label>
<input type="file" name="imagem" accept="image/*" required>

<label>Desenvolvedora</label>
<input type="text" name="desenvolvedora">

<label>Publicadora</label>
<input type="text" name="publicadora">

<label>Gênero</label>
<input type="text" name="genero">

<label>Plataformas</label>
<input type="text" name="plataformas">

<label>Tamanho</label>
<input type="text" name="tamanho">

<label>Versão</label>
<input type="text" name="versao">

<label>Classificação</label>
<input type="text" name="classificacao">

<label>Idiomas</label>
<input type="text" name="idiomas">

<label>Modo</label>
<input type="text" name="modo">

<label>Ano de lançamento</label>
<input type="number" name="data_lancamento" min="1900" max="2100">

<label>Licença</label>
<input type="text" name="licenca">

<button type="submit" name="b1" class="botao-principal">Adicionar produto</button>

</form>

</main>

</body>
</html>
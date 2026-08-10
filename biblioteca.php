<?php
if (!isset($_SESSION)) session_start();

if (empty($_SESSION["logado"])) {
    header("Location: login.php");
    exit;
}

$compras = [];

if (is_dir("vendas")) {
    $pasta = opendir("vendas");
    while (($arquivo = readdir($pasta)) !== false) {
        if ($arquivo != "." && $arquivo != "..") {
            $caminho = "vendas/" . $arquivo;
            $f = fopen($caminho, "r");
            $venda = [];
            while (!feof($f)) {
                $linha = trim(fgets($f, 1000));
                if ($linha != "") {
                    $partes = explode(": ", $linha, 2);
                    if (count($partes) == 2) {
                        $venda[$partes[0]] = $partes[1];
                    }
                }
            }
            fclose($f);
            if (!empty($venda["CPF do usuário"]) && $venda["CPF do usuário"] == $_SESSION["cpf"]) {
                $compras[] = $venda;
            }
        }
    }
    closedir($pasta);
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
    <div class="marca"><img src="img/steam-logo.png" alt="Logo" class="logo-site"><div><h1>PoubreSteam</h1><p>Biblioteca</p></div></div>
    <nav class="menu-principal"><a href="index.php">Loja</a><a href="carrinho.php">Carrinho</a><a href="biblioteca.php">Biblioteca</a><a href="sobre.php">Sobre</a></nav>
    <div class="area-login"><p class="texto-usuario"><?= htmlspecialchars($_SESSION["nome"]) ?></p><a href="logout.php" class="botao-secundario">Sair</a></div>
</header>

<main class="conteudo-principal">
    <h2 class="titulo-secao">Sua biblioteca</h2>
    <?php if (empty($compras)): ?>
        <div class="painel-vazio"><h3>Nenhuma compra registrada ainda.</h3><p>Quando você finalizar uma compra, ela aparecerá aqui.</p></div>
    <?php else: ?>
        <div class="grade-biblioteca">
            <?php foreach ($compras as $compra): ?>
                <div class="cartao-biblioteca">
                    <h3>Venda <?= htmlspecialchars($compra["Número da venda"]) ?></h3>
                    <p><strong>Jogos:</strong> <?= htmlspecialchars($compra["Produtos"]) ?></p>
                    <p><strong>Total:</strong> R$ <?= number_format($compra["Valor total"], 2, ",", ".") ?></p>
                    <p><strong>Data:</strong> <?= htmlspecialchars($compra["Data e hora"]) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
<footer><p>PoubreSteam &copy; 2026 - Todos os direitos reservados.</p></footer>
</body>
</html>

<?php
if (!isset($_SESSION)) session_start();
include "produtos.php";

if (empty($_SESSION["logado"]) || !isset($_POST["b1"])) {
    header("Location: index.php");
    exit;
}

if (!is_dir("vendas")) {
    mkdir("vendas", 0777, true);
}

date_default_timezone_set("America/Sao_Paulo");

$pagamento = trim($_POST["pagamento"] ?? "");
$itensCompra = [];

if (!empty($_SESSION["produto_pendente"])) {
    $itensCompra[] = $_SESSION["produto_pendente"];
} else if (!empty($_SESSION["carrinho"])) {
    $itensCompra = $_SESSION["carrinho"];
}

if (empty($itensCompra)) {
    header("Location: index.php");
    exit;
}

$numeroVenda = date("YmdHis") . rand(100, 999);
$nomesProdutos = [];
$total = 0;

foreach ($itensCompra as $id) {
    if (isset($produtos[$id])) {
        $nomesProdutos[] = $produtos[$id]["nome"];
        $total = $total + $produtos[$id]["preco"];
    }
}

$f = fopen("vendas/venda_".$numeroVenda.".DAT", "w");
fwrite($f, "Número da venda: ".$numeroVenda."\n");
fwrite($f, "Nome do usuário: ".$_SESSION["nome"]."\n");
fwrite($f, "CPF do usuário: ".$_SESSION["cpf"]."\n");
fwrite($f, "Produtos: ".implode(", ", $nomesProdutos)."\n");
fwrite($f, "Valor total: ".$total."\n");
fwrite($f, "Forma de pagamento: ".$pagamento."\n");
fwrite($f, "Data e hora: ".date("d/m/Y H:i:s")."\n");
fclose($f);

unset($_SESSION["produto_pendente"], $_SESSION["carrinho"]); // unset pode apagar várias sessões de uma vez.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Compra Finalizada - PoubreSteam</title>
    <link rel="stylesheet" href="css/style.css?v=4">
</head>
<body class="pagina-login">

<div class="caixa-formulario">
    <h1>Compra confirmada!</h1>
    <div class="alerta sucesso">Sua compra foi registrada com sucesso.</div>

    <p><strong>Número da venda:</strong> <?= $numeroVenda ?></p>
    <p><strong>Produtos:</strong> <?= htmlspecialchars(implode(", ", $nomesProdutos)) ?></p>
    <p><strong>Total:</strong> R$ <?= number_format($total, 2, ",", ".") ?></p>
    <p><strong>Pagamento:</strong> <?= htmlspecialchars($pagamento) ?></p>
    <p><strong>Data:</strong> <?= date("d/m/Y H:i:s") ?></p>

    <a href="biblioteca.php" class="botao-principal atalho-botao">Ver biblioteca</a>
    <a href="index.php" class="atalho-voltar">Voltar para a loja</a>
</div>

</body>
</html>

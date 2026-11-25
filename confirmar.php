
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "app/cons.php";
require_once "app/DLL.php";
include "produtos.php";

if (empty($_SESSION["logado"])) {
    header("Location: login.php");
    exit;
}

// Limpa os dados de uma compra anterior ao iniciar outra.
if (
    isset($_POST["b_comprar"]) ||
    isset($_POST["b_finalizar"])
) {
    unset($_SESSION["venda_concluida"]);
    unset($_SESSION["numero_venda"]);
    unset($_SESSION["nomes_produtos"]);
    unset($_SESSION["total_venda"]);
    unset($_SESSION["forma_pagamento"]);
}

// Produto comprado diretamente pela loja.
if (isset($_POST["b_comprar"]) && !empty($_POST["produto_id"])) {
    $_SESSION["produto_pendente"] = (int) $_POST["produto_id"];
}

$erro = $_SESSION["erro_venda"] ?? "";
unset($_SESSION["erro_venda"]);

$vendaConcluida = !empty($_SESSION["venda_concluida"]);

$itensCompra = [];
$total = 0;

$usuario = [];
$endereco = [
    "endereco" => "",
    "bairro" => "",
    "cidade" => "",
    "estado" => "",
    "cep" => ""
];

if (!$vendaConcluida) {

    // Identifica os produtos da compra.
    if (!empty($_SESSION["produto_pendente"])) {

        $idProduto = (int) $_SESSION["produto_pendente"];

        if (isset($produtos[$idProduto])) {
            $itensCompra[] = $idProduto;
        }

    } elseif (!empty($_SESSION["carrinho"])) {

        $itensCompra = $_SESSION["carrinho"];
    }

    if (empty($itensCompra)) {
        header("Location: index.php");
        exit;
    }

    // Agrupa produtos repetidos para calcular as quantidades.
    $quantidades = array_count_values($itensCompra);

    // Recupera os dados do comprador pelo CPF.
    $cpf = $_SESSION["cpf"] ?? "";

    if (empty($cpf)) {
        $_SESSION["erro_venda"] =
            "Não foi possível identificar sua conta. Faça login novamente.";

        header("Location: login.php");
        exit;
    }

    $consultaUsuario = "SELECT *
                        FROM usuario
                        WHERE cpf = '$cpf'";

    $resultadoUsuario = banco(
        $server,
        $user,
        $password,
        $db,
        $consultaUsuario
    );

    $usuario = $resultadoUsuario->fetch_assoc();

    if (!$usuario) {
        $_SESSION["erro_venda"] = "Usuário não encontrado.";

        header("Location: login.php");
        exit;
    }

    $id_usuario = $usuario["id_usuario"];

    // Recupera o endereço do comprador.
    $consultaEndereco = "SELECT *
                         FROM endereco
                         WHERE id_usuario = '$id_usuario'";

    $resultadoEndereco = banco(
        $server,
        $user,
        $password,
        $db,
        $consultaEndereco
    );

    $dadosEndereco = $resultadoEndereco->fetch_assoc();

    if ($dadosEndereco) {
        $endereco = array_merge($endereco, $dadosEndereco);
    }

    // Calcula o total considerando as quantidades.
    foreach ($quantidades as $id => $quantidade) {

        $id = (int) $id;

        if (isset($produtos[$id])) {

            $preco = (float) $produtos[$id]["preco"];

            $total += $preco * $quantidade;
        }
    }
}

// Dados seguros para exibição.
$nomeUsuario = $_SESSION["nome"] ?? "Usuário";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <title>Confirmar Compra - PoubreSteam</title>

    <link rel="stylesheet" href="css/style.css?v=4">
</head>

<body>

<header class="topo">

    <div class="marca">

        <img
            src="img/steam-logo.png"
            alt="Logo"
            class="logo-site">

        <div>
            <h1>PoubreSteam</h1>
            <p>Confirmação de compra</p>
        </div>

    </div>

    <nav class="menu-principal">

        <a href="index.php">Loja</a>
        <a href="carrinho.php">Carrinho</a>
        <a href="biblioteca.php">Biblioteca</a>
        <a href="sobre.php">Sobre</a>

    </nav>

    <div class="area-login">

        <p class="texto-usuario">
            <?= htmlspecialchars($nomeUsuario) ?>
        </p>

        <a
            href="logout.php"
            class="botao-secundario">
            Sair
        </a>

    </div>

</header>

<main class="conteudo-principal confirmar-layout">

<?php if ($vendaConcluida): ?>

    <!-- TELA DE COMPRA CONCLUÍDA -->

    <section class="cartao-confirmacao">

        <div class="alerta sucesso" role="status">
            Compra registrada com sucesso!
        </div>

        <h2>Compra concluída</h2>

        <p>
            <strong>Número da venda:</strong>
            <?= htmlspecialchars($_SESSION["numero_venda"] ?? "") ?>
        </p>

        <h3>Produtos comprados</h3>

        <?php foreach ($_SESSION["nomes_produtos"] ?? [] as $nomeProduto): ?>

            <p>
                <?= htmlspecialchars($nomeProduto) ?>
            </p>

        <?php endforeach; ?>

        <p>
            <strong>Forma de pagamento:</strong>
            <?= htmlspecialchars($_SESSION["forma_pagamento"] ?? "") ?>
        </p>

        <strong class="preco-grande">

            Total: R$

            <?= number_format(
                (float) ($_SESSION["total_venda"] ?? 0),
                2,
                ",",
                "."
            ) ?>

        </strong>

        <a
            href="index.php"
            class="botao-principal atalho-botao">

            Voltar para a loja

        </a>

    </section>

<?php else: ?>

    <?php if (!empty($erro)): ?>

        <div class="alerta erro" role="alert">
            <?= htmlspecialchars($erro) ?>
        </div>

    <?php endif; ?>

    <!-- INFORMAÇÕES DOS PRODUTOS -->

    <section class="cartao-confirmacao">

        <h2>Produto escolhido</h2>

        <?php foreach ($quantidades as $id => $quantidade): ?>

            <?php
            $id = (int) $id;

            if (!isset($produtos[$id])) {
                continue;
            }

            $produto = $produtos[$id];

            $preco = (float) $produto["preco"];

            $subtotal = $preco * $quantidade;
            ?>

            <div class="produto-confirmar">

                <img
                    src="<?= htmlspecialchars($produto["imagem"]) ?>"
                    alt="<?= htmlspecialchars($produto["nome"]) ?>">

                <div>

                    <h3>
                        <?= htmlspecialchars($produto["nome"]) ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars($produto["descricao"]) ?>
                    </p>

                    <p>
                        <strong>Desenvolvedora:</strong>
                        <?= htmlspecialchars($produto["desenvolvedora"] ?? "") ?>
                    </p>

                    <p>
                        <strong>Publicadora:</strong>
                        <?= htmlspecialchars($produto["publicadora"] ?? "") ?>
                    </p>

                    <p>
                        <strong>Gênero:</strong>
                        <?= htmlspecialchars($produto["genero"] ?? "") ?>
                    </p>

                    <p>
                        <strong>Plataformas:</strong>
                        <?= htmlspecialchars($produto["plataformas"] ?? "") ?>
                    </p>

                    <p>
                        <strong>Tamanho:</strong>
                        <?= htmlspecialchars($produto["tamanho"] ?? "") ?>
                    </p>

                    <p>
                        <strong>Versão:</strong>
                        <?= htmlspecialchars($produto["versao"] ?? "") ?>
                    </p>

                    <p>
                        <strong>Classificação indicativa:</strong>
                        <?= htmlspecialchars($produto["classificacao"] ?? "") ?>
                    </p>

                    <p>
                        <strong>Idiomas:</strong>
                        <?= htmlspecialchars($produto["idiomas"] ?? "") ?>
                    </p>

                    <p>
                        <strong>Modo de jogo:</strong>
                        <?= htmlspecialchars($produto["modo"] ?? "") ?>
                    </p>

                    <p>
                        <strong>Data de lançamento:</strong>
                        <?= htmlspecialchars($produto["data_lancamento"] ?? "") ?>
                    </p>

                    <p>
                        <strong>Licença:</strong>
                        <?= htmlspecialchars($produto["licenca"] ?? "") ?>
                    </p>

                    <p>
                        <strong>Quantidade:</strong>
                        <?= (int) $quantidade ?>
                    </p>

                    <p>
                        <strong>Preço unitário:</strong>

                        R$
                        <?= number_format(
                            $preco,
                            2,
                            ",",
                            "."
                        ) ?>
                    </p>

                    <strong>
                        Subtotal: R$

                        <?= number_format(
                            $subtotal,
                            2,
                            ",",
                            "."
                        ) ?>
                    </strong>

                </div>

            </div>

        <?php endforeach; ?>

        <strong class="preco-grande">

            Total:

            R$

            <?= number_format(
                $total,
                2,
                ",",
                "."
            ) ?>

        </strong>

    </section>

    <!-- DADOS DO COMPRADOR -->

    <section class="cartao-confirmacao">

        <h2>Dados do comprador</h2>

        <p>
            <strong>Nome:</strong>

            <?= htmlspecialchars($usuario["nome"] ?? "") ?>
        </p>

        <p>
            <strong>CPF:</strong>

            <?= htmlspecialchars($usuario["cpf"] ?? "") ?>
        </p>

        <p>
            <strong>Endereço:</strong>

            <?= htmlspecialchars($endereco["endereco"] ?? "") ?>
        </p>

        <p>
            <strong>Bairro:</strong>

            <?= htmlspecialchars($endereco["bairro"] ?? "") ?>
        </p>

        <p>
            <strong>Cidade:</strong>

            <?= htmlspecialchars($endereco["cidade"] ?? "") ?>
        </p>

        <p>
            <strong>Estado:</strong>

            <?= htmlspecialchars($endereco["estado"] ?? "") ?>
        </p>

        <p>
            <strong>CEP:</strong>

            <?= htmlspecialchars($endereco["cep"] ?? "") ?>
        </p>

        <!-- PAGAMENTO -->

        <form
            action="salvar_venda.php"
            method="POST">

            <label>
                Forma de pagamento
            </label>

            <select
                name="pagamento"
                required>

                <option value="">
                    Selecione
                </option>

                <option value="Pix">
                    Pix
                </option>

                <option value="Cartão de Crédito">
                    Cartão de Crédito
                </option>

                <option value="Boleto">
                    Boleto
                </option>

                <option value="Saldo PoubreSteam">
                    Saldo PoubreSteam
                </option>

            </select>

            <button
                type="submit"
                name="b1"
                class="botao-principal">

                Confirmar compra

            </button>

        </form>

    </section>

<?php endif; ?>

</main>

<footer>

    <p>
        PoubreSteam &copy; 2026 - Todos os direitos reservados.
    </p>

</footer>

</body>
</html>

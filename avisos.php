<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION["aviso"])):
    $aviso = $_SESSION["aviso"];
    unset($_SESSION["aviso"]);
?>
<div class="aviso <?= htmlspecialchars($aviso["tipo"] ?? "info", ENT_QUOTES, "UTF-8") ?>" role="alert" data-aviso>
    <?= htmlspecialchars($aviso["texto"] ?? "", ENT_QUOTES, "UTF-8") ?>
    <button type="button" class="aviso-fechar" aria-label="Fechar aviso">&times;</button>
</div>
<script src="js/avisos.js" defer></script>
<?php endif; ?>

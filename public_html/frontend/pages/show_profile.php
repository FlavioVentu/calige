<?php
require_once "backend/components/header.php";
require_once "backend/components/navbar.php";
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION["user"];
?>

<div class="container text-white pt-5">
    <h2 class="text-center mb-4">Il tuo profilo</h2>
    <div class="col-md-6 offset-md-3">
        <p><strong>Nome utente:</strong> <?= htmlspecialchars($user["username"]) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user["email"]) ?></p>
        <a href="update_profile.php" class="btn btn-secondary mt-3">Modifica profilo</a>
    </div>
</div>

<?php
require_once "backend/components/footer.html";
?>

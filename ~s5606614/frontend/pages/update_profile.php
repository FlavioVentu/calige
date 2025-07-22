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
    <h2 class="text-center mb-4">Modifica profilo</h2>
    <form action="backend/handlers/update_profile.php" method="POST" class="col-md-6 offset-md-3">
        <div class="mb-3">
            <label for="username" class="form-label">Nome utente</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user["username"]) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Salva modifiche</button>
    </form>
</div>

<?php
require_once "backend/components/footer.html";
?>

<?php
require_once "../../backend/components/header.php";
require_once "../../backend/components/navbar.php";
?>

<div class="container text-white pt-5">
    <h2 class="text-center mb-4">Accedi</h2>
    <form action="backend/handlers/login.php" method="POST" class="col-md-6 offset-md-3">
        <div class="mb-3">
            <label for="username" class="form-label">Nome utente</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Accedi</button>
    </form>
</div>

<?php
require_once "../../backend/components/footer.html";
?>

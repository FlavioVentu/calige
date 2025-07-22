<?php

require_once '../../backend/utils/functions.php';

require_once "../../backend/components/header.php";

require_once "../../backend/components/navbar.php";
?>

<div class="container text-white pt-5">
    <h2 class="text-center mb-4">Accedi</h2>
    <form action="../../backend/api/login.php" method="post">
        <input type="email" name="email">
        <input type="password" name="pass">
        <input type="submit" name="submit" value="Invia">
    </form>
</div>

<?php
require_once "../../backend/components/footer.html";
?>

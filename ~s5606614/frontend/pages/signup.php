<?php

require_once '../../backend/utils/functions.php';

require_once "../../backend/components/header.php";

require_once "../../backend/components/navbar.php";
?>

<div class="container text-white pt-5">
    <h2 class="text-center mb-4">Registrati</h2>
    <form action="../../backend/api/registration.php" method="post">
        <input type="text" name="firstname">
        <input type="text" name="lastname">
        <input type="email" name="email">
        <input type="password" name="pass">
        <input type="password" name="confirm">
        <input type="submit" name="submit" value="Invia">
    </form>
</div>

<?php
require_once "../../backend/components/footer.html";
?>

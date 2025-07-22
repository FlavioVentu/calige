<?php

session_start();

# se l'utente ha già fatto login rimandiamo alla home page
if(isset($_SESSION['username'])) {
    header("Location: /~s5606614/");
}

require_once '../../backend/utils/functions.php';

require_once "../../backend/components/header.php";

require_once "../../backend/components/navbar.php";
?>
<div class="d-flex justify-content-center align-items-center min-vh-100" id="login">

<div class="container cali_color_text">
    <div class="row justify-content-center p-5">
        <div class="col-lg-8 col-10 pt-5 px-5 form border rounded shadow-lg">
            <h1 class="text-center text-white mb-4">Accedi</h1>
            <form action="../../backend/api/login.php" method="post">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                    <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="password">
                    <label for="pass">Password</label>
                </div>
                <div class="d-flex justify-content-center align-items-center mt-4">
                    <input type="submit" class="text-center btn cali_color text-white btn-lg px-5 py-3" name="submit" value="Invia">
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<?php
require_once "../../backend/components/footer.html";
?>

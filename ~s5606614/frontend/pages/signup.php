<?php

require_once "../../backend/utils/Log.php";
ErrorLog::logGeneral();

session_start();

# se l'utente ha già fatto login rimandiamo alla home page
if(isset($_SESSION['username'])) {
    header("Location: /~s5606614/");
}

require_once '../../backend/utils/functions.php';

require_once "../../backend/components/header.php";

require_once "../../backend/components/navbar.php";
?>

<div class="d-flex justify-content-center align-items-center min-vh-100" id="signup">

    <div class="container cali_color_text">
        <div class="row justify-content-center py-5">
            <div class="col-lg-8 col-10 pt-5 px-5 form border rounded shadow-lg">

                <!-- HEADING -->
                <h1 class="text-center text-white mb-4">Registrati</h1>
                <div class="d-flex justify-content-center mb-2 d-none">
                    <div class="alert text-center py-2 w-sm-50" id="alert"></div>
                </div>

                <!-- FORM -->
                <form action="../../backend/api/registration.php" method="post">
                    <div class="row">

                        <!-- NOME -->
                        <div class="col-lg-6 form-floating mb-3">
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Marco">
                            <label for="firstname" class="ms-2">Nome</label>
                        </div>

                        <!-- COGNOME -->
                        <div class="col-lg-6 form-floating mb-3">
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Rossi">
                            <label for="lastname" class="ms-2">Cognome</label>
                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                        <label for="email">Email</label>
                    </div>
                    <div class="row">

                        <!-- PASSWORD -->
                        <div class="col-lg-6 form-floating mb-3">
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="password">
                            <label for="pass" class="ms-2">Password</label>
                        </div>

                        <!-- CONFERMA -->
                        <div class="col-lg-6 form-floating mb-3">
                            <input type="password" class="form-control" id="confirm" name="confirm" placeholder="conferma password">
                            <label for="confirm" class="ms-2">Conferma</label>
                        </div>
                    </div>

                    <!-- SUBMIT -->
                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <input type="submit" class="text-center btn cali_color text-white btn-lg px-5 py-3" name="submit" id="submit" value="Invia">
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?php
require_once "../../backend/components/footer.html";
?>

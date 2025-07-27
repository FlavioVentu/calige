<?php

require_once "../../backend/utils/Log.php";
ErrorLog::logGeneral();

session_start();

# se l'utente non ha già fatto login rimandiamo alla login page
if(!isset($_SESSION['username'])) {
    header("Location: /~s5606614/frontend/pages\login.php");
}

require_once '../../backend/utils/functions.php';

require_once "../../backend/components/header.php";

require_once "../../backend/components/navbar.php";
?>
<div class="d-flex justify-content-center align-items-center min-vh-100" id="show_profile">

    <div class="container cali_color_text">
        <div class="row justify-content-center py-5">
            <div class="col-lg-8 col-10 pt-5 px-5 form border rounded shadow-lg">

                <!-- HEADING -->
                <h1 class="text-center text-white mb-4">Profilo</h1>
                <div class="d-flex justify-content-center mb-2 d-none">
                    <div class="alert text-center py-2 w-sm-50" id="alert"></div>
                </div>
                <div class="row justify-content-center">

                    <!-- DATI -->
                    <ul class="col-12 list-group text-center mb-5">

                        <!-- USERNAME -->
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3 cali_color text-white py-2">Username</div>
                                <div class="col-md-9 text-truncate py-2 text-start" id="username"></div>
                            </div>
                        </li>

                        <!-- NOME -->
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3 cali_color text-white py-2">Nome</div>
                                <input type="text" class="col-md-9 text-truncate py-2 text-start" id="firstname">
                            </div>
                        </li>

                        <!-- COGNOME -->
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3 cali_color text-white py-2">Cognome</div>
                                <input type="text" class="col-md-9 text-truncate py-2 text-start" id="lastname">
                            </div>
                        </li>

                        <!-- EMAIL -->
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3 cali_color text-white py-2">Email</div>
                                <input type="text" class="col-md-9 text-truncate py-2 text-start" id="email">
                            </div>
                        </li>

                    </ul>

                    <!-- BOTTONI MODIFICA DATI -->
                    <a href="" class="btn btn-lg col-lg-4 text-white disabled"><i class="bi bi-person-bounding-box me-2"></i>Modifica username</a>
                    <button class="btn btn-lg col-lg-4 text-white" id="update"><i class="bi bi-person-lines-fill me-2"></i>Modifica profilo</button>
                    <a href="" class="btn btn-lg col-lg-4 text-white disabled"><i class="bi bi-key-fill me-2"></i>Modifica password</a>

                </div>

            </div>
        </div>
    </div>

</div>
<?php
require_once "../../backend/components/footer.html";
?>


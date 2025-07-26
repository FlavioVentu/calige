<?php

require_once "../../backend/utils/Log.php";
ErrorLog::logGeneral();

require_once '../../backend/utils/functions.php';

require_once "../../backend/components/header.php";

require_once "../../backend/components/navbar.php";
?>
<div class="d-flex justify-content-center align-items-center min-vh-100" id="parco">

    <div class="container cali_color_text">
        <div class="row justify-content-center py-5">
            <div class="py-3 px-3 row cali_color border rounded-4 shadow-lg">

                <!-- MAPPA -->
                <div class="col-md-6 border rounded-md-start" id="map"></div>

                <!-- DATI PARCO -->
                <div class="col-md-6 card cali_color text-white p-3">
                    <div class="card-body">
                        <h1 class="card-title mb-5 pt-3" id="titolo"></h1>
                        <hr>
                        <p class="card-text h5 lh-lg" id="descrizione"></p>
                        <hr>
                        <p class="card-text h5 lh-lg" id="city"><b><i class="bi bi-house-door-fill me-2"></i></b></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
require_once "../../backend/components/footer.html";
?>


<?php

require_once "../../backend/utils/Log.php";
ErrorLog::logGeneral();

session_start();

require_once '../../backend/utils/functions.php';

require_once "../../backend/components/header.php";

require_once "../../backend/components/navbar.php";
?>
<div class="d-flex row p-5 justify-content-center align-items-center min-vh-100" id="parco">

    <div class="container cali_color_text col-10">
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
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <p class="card-text h5 d-sm-inline lh-lg" id="valutazione"><b><i class="bi bi-star-fill text-warning me-2"></i></b></p>
                            <button class="btn btn-light" id="recensioni">Leggi recensioni</button>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
<?php
    if(isset($_SESSION['username'])) {
        echo <<< REVIEW
            <div class="row col-10 col-lg-5 justify-content-center py-2">
            <div class="py-3 px-3 cali_color border rounded-4 shadow-lg">
                <div class="card cali_color text-white p-3">
                    <div class="card-body">
                        <form>
                            <label for="stars" class="form-label">Valutazione</label>
                            <input type="range" class="form-range" min="1" max="5" value="3" id="stars">
                            <output for="stars" id="range" ><i class="bi bi-star-fill text-warning ms-2"></i></output>

                            <div class="mb-3">
                                <label for="testo" class="form-label">Testo (opzionale)</label>
                                <textarea class="form-control" id="testo" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="text-center btn btn-primary btn-lg" name="submit" id="submit" value="Invia">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        REVIEW;
    }
    ?>
</div>

<?php
require_once "../../backend/components/footer.html";
?>


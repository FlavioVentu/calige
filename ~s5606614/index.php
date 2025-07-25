<?php

session_start();

require_once 'backend/utils/functions.php';

# Header
require_once "backend/components/header.php";

# Navbar
require_once "backend/components/navbar.php";

?>


    <!-- PARTE CENTRALE -->
    <div class="min-vh-100 pt-5" id="home">
        <div class="container-fluid text-center pb-5 text-white" role="complementary">
<?php
if(!$login) {
        echo '<h1 class="display-3 pt-5">Benvenuto su CALI<i>ge</i></h1>';
}
else {
        echo '<h1 class="display-3 pt-5">Bentornato su CALI<i>ge</i></h1>';
}

            ?>
            <h2 class="display-4">La community dei parchetti Calisthenics di Genova
            </h2>
            <div class="row justify-content-center">
                <i class="bi bi-activity pt-5 h4"></i>
                <p class="col-sm-5 col-10 h4 lh-lg">Ti alleni nei parchi pubblici di Genova o vorresti iniziare? Sei
                    nel posto giusto.
                    Questo sito nasce per raccogliere e far crescere la community del Calisthenics genovese,
                    valorizzando i
                    parchetti pubblici della città: quegli spazi all'aperto dove ogni giorno si suda, si migliora, si
                    condividono passioni e si crea legame.
                </p>
            </div>

            <!-- PARTE PARCHETTI -->
            <h3 class="display-6 mt-5 p-5"><i class="bi bi-pin-fill"></i> Scopri i parchetti:
                trova
                i migliori
                spot in città, con recensioni reali
                da
                chi li
                frequenta.</h3>

            <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 d-flex align-items-stretch" id="main" role="group">

                <!-- SEZIONE PARCHI -->

            </div>

            <!-- PARTE FORUM -->
            <h3 class="display-6 p-5 mt-5"><i class="bi bi-send-fill"></i> Partecipa al forum: lascia una
                recensione, segnala problemi, proponi
                miglioramenti oppure organizza un allenamento di gruppo.
            </h3>

            <!-- TODO: realizzare la parte del forum -->


        </div>
    </div>

<?php

# Footer
require_once "backend/components/footer.html";

?>

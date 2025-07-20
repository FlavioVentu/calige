<?php

# Header
require_once "backend/components/header.php";

# Navbar
require_once "backend/components/navbar.php";

?>


    <!-- PARTE CENTRALE -->
    <div class="min-vh-100 pt-5" id="sfondo">
        <div class="container-fluid text-center pb-5 text-white" role="complementary">
            <h1 class="display-3 pt-5">Benvenuto su CALI<i>ge</i></h1>
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

            <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 d-flex align-items-stretch" role="group">

                <!-- CALISAURO -->
                <div class="col">
                    <div class="card m-5 rounded-5">
                        <img src="/frontend/images/parchi/genova_sauro.jpg"
                            class="card-img-top rounded-5 rounded-bottom-0" alt="Parco calistenico del CaliSauro">
                        <div class="card-body text-white">
                            <h5 class="card-title">CaliSauro</h5>
                            <p class="card-text">viale Nazario Sauro</p>
                            <a href="#" class="btn btn-primary">visita</a>
                        </div>
                    </div>
                </div>

                <!-- GENOVA PRA -->
                <div class="col">
                    <div class="card m-5 rounded-5">
                        <img src="/frontend/images/parchi/genova_pra.jpg"
                            class="card-img-top rounded-5 rounded-bottom-0" alt="Parco calistenico di Genova Pra">
                        <div class="card-body text-white">
                            <h5 class="card-title">Genova Pra</h5>
                            <p class="card-text">Lungo la passeggiata di prà</p>
                            <a href="#" class="btn btn-primary">Visita</a>
                        </div>
                    </div>
                </div>

                <!-- GENOVA NERVI -->
                <div class="col">
                    <div class="card m-5 rounded-5">
                        <img src="/frontend/images/parchi/genova_nervi.jpg"
                            class="card-img-top rounded-5 rounded-bottom-0" alt="Parco calistenico di Genova Nervi">
                        <div class="card-body text-white">
                            <h5 class="card-title">Genova Nervi</h5>
                            <p class="card-text">Lungo la passegata di nervi</p>
                            <a href="#" class="btn btn-primary">Visita</a>
                        </div>
                    </div>
                </div>

                <!-- ERZELLI -->
                <div class="col">
                    <div class="card m-5 rounded-5">
                        <img src="/frontend/images/parchi/genova_erzelli.jpg"
                            class="card-img-top rounded-5 rounded-bottom-0" alt="Parco calistenico degli Erzelli">
                        <div class="card-body text-white">
                            <h5 class="card-title">Erzelli</h5>
                            <p class="card-text">Via Enrico Melen 77</p>
                            <a href="#" class="btn btn-primary">Visita</a>
                        </div>
                    </div>
                </div>

                <!-- CUS GENOVA -->
                <div class="col">
                    <div class="card m-5 rounded-5">
                        <img src="/frontend/images/parchi/genova_cus.jpg"
                            class="card-img-top rounded-5 rounded-bottom-0" alt="Parco calistenico del Cus Genova">
                        <div class="card-body text-white">
                            <h5 class="card-title">Cus Genova</h5>
                            <p class="card-text">via Dodecaneso</p>
                            <a href="#" class="btn btn-primary">Visita</a>
                        </div>
                    </div>
                </div>

                <!-- GENOVA PRINCIPE -->
                <div class="col">
                    <div class="card m-5 rounded-5">
                        <img src="/frontend/images/parchi/genova_principe.jpg"
                            class="card-img-top rounded-5 rounded-bottom-0" alt="Parco calistenico di Genova Principe">
                        <div class="card-body text-white">
                            <h5 class="card-title">Genova Principe</h5>
                            <p class="card-text">Giardini Carlo Malinverni</p>
                            <a href="#" class="btn btn-primary">Visita</a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- PARTE FORUM -->
            <h3 class="display-6 p-5 mt-5"><i class="bi bi-send-fill"></i> Partecipa al forum: lascia una
                recensione, segnala problemi, proponi
                miglioramenti o organizza un allenamento di gruppo.
            </h3>

            <!-- TODO: realizzare la parte del forum -->


        </div>
    </div>

<?php

# Footer
require_once "backend/components/footer.html";

?>

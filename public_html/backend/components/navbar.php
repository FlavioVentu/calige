<body>


    <!-- NAVBAR -->
    <nav class="sticky-top navbar cali_color navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">

            <!-- parte logo (alto a sinistra) -->
            <a class="navbar-brand px-3" href="">CALI<i>ge</i></a>

            <!-- parte mobile 3 linee -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end cali_color" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">

                    <!-- parte interna a lato mobile in alto (menu e tasto per chiuderlo) -->
                    <h5 class="offcanvas-title border-bottom text-white" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <!-- link della navbar -->
                <div class="offcanvas-body text-center">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                        <!-- FORUM -->
                        <li class="nav-item me-lg-5 mb-lg-0 mb-4"><a class="nav-link" aria-current="page"
                                href="">Forum</a></li>

                        <!-- REGISTRAZIONE -->
                        <li class="nav-item me-lg-3 mb-lg-0 mb-3"><a class="btn btn-light" href="/frontend/pages/signup.php" role="button"
                                aria-label="Clicca per andare alla pagina di registrazione">Sign Up</a></li>

                        <!-- LOGIN -->
                        <li class="nav-item me-lg-3"><a class="btn btn-dark" href="" role="button"
                                aria-label="Clicca per andare alla pagina del login">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
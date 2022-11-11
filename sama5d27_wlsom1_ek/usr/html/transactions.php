<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$id = $_SESSION["id"];
$auth = $_SESSION["auth"];
$firstlogin = $_SESSION["firstlogin"];
if ($firstlogin == 1) {
    header("location: change_password.php");
    exit;
}
require_once "inc/config.php";
// 0=admin 1=installer 2=user
if ($auth == 0) {
    $utente = 'admin';
} elseif ($auth == 1) {
    $utente = 'installer';
} else {
    $utente = 'user';
    $configuration_menu = "";
}
?>
<!--# if expr="$internetenabled=false" -->
<!--# include file="session.php" -->
<!--# include file="index_provisioning.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="it">

<head>
    <title>DKC E.CHARGER | TRANSAZIONI</title>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/logged.css" rel="stylesheet" type="text/css" />
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
    <link href="favicon.png" rel="icon" type="image/png" />
</head>

<body>
    <header class="navbar sticky-top bg-dkcenergy flex-md-nowrap p-0 shadow">
        <span class="navbar-brand col-md-3 col-lg-2 me-0 px-1">
            <img src="img/logo_menu.png" width="164" height="50">
        </span>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        </button>
        <div class="dropdown me-2">
            <button type="button" class="btn btn-sm dropdown-toggle" style="background-color:#d91a15; color:#fff;" id="dropdownUser" data-bs-toggle="dropdown" data-toggle="tooltip" data-bs-placement="left" title="<?php echo htmlspecialchars($utente); ?>">
                <img src="img/ico_user.png" class="me-3">
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="index_dashboard.php">HOME</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-primary" href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </header>
    <!-- ################################# INIZIO MENU DESKTOP ################################################ -->
    <nav role="navigation" class="d-none col-md-3 col-lg-2 d-md-block bg-dkcenergy sidebar dkc-laterale">
        <div class="position-sticky pt-3">
            <div class="nav flex-column me-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-dkcenergy">
                        <h5 class="fw-bolder" style="color:#b0b0b0;">
                            <img src="img/ico_overview.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            OVERVIEW
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="index_dashboard.php">
                                <img src="img/ico_wallbox.png" width="25px" class="me-3">
                                E.CHARGER
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="telemetry.php">
                                <img src="img/ico_inverter.png" width="25px" class="me-3">
                                TELEMETRIA
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="cards.php">
                                <img src="img/ico_card.png" width="25px" class="me-3">
                                CARTE RFID
                            </a>
                        </div>
                    </li>
                    <hr class="border border-secondary border-1 opacity-75 ms-2">
                    <li class="list-group-item bg-dkcenergy">
                        <h5 class="fw-bolder" style="color:#b0b0b0;">
                            <img src="img/ico_statistiche.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            STATISTICHE
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="transactions.php" class="dkc-selected">
                                <img src="img/ico_service.png" width="25px" class="me-3">
                                TRANSAZIONI
                            </a>
                        </div>
                    </li>
                    <hr class="border border-secondary border-1 opacity-75 ms-2">
                    <li class="list-group-item bg-dkcenergy">
                        <h5 class="fw-bolder" style="color:#b0b0b0;">
                            <img src="img/ico_settings.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            IMPOSTAZIONI
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="commands.php">
                                <img src="img/ico_notifiche.png" width="25px" class="me-3">
                                COMANDI
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="configurations.php">
                                <img src="img/ico_portale.png" width="25px" class="me-3">
                                CONFIGURAZIONI
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="errors.php">
                                <img src="img/ico_error.png" width="25px" class="me-3">
                                ERRORI
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="network.php">
                                <img src="img/ico_network.png" width="25px" class="me-3">
                                RETE
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- ################################# FINE MENU DESKTOP ################################################ -->
    <!-- ################################# INIZIO MENU MOBILE ################################################ -->
    <div class="offcanvas offcanvas-start" style="background-color: #0e1b35" tabindex="-1" id="offcanvasFunzioni" aria-labelledby="offcanvasFunzioniLabel" data-bs-toggle="offcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasFunzioniLabel"><img src="img/logo_menu.png" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_overview.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">OVERVIEW</h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b>CHIUDI </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="index_dashboard.php">
                            <img src="img/ico_wallbox.png" width="25px" class="me-3">
                            E.CHARGER
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="telemetry.php">
                            <img src="img/ico_inverter.png" width="25px" class="me-3">
                            TELEMETRIA
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="cards.php">
                            <img src="img/ico_card.png" width="25px" class="me-3">
                            CARTE RFID
                        </a>
                    </h4>
                </li>
            </ul>
        </div>
    </div>
    <div class="offcanvas offcanvas-start" style="background-color: #0e1b35" tabindex="-1" id="offcanvasStatistiche" aria-labelledby="offcanvasStatisticheLabel" data-bs-toggle="offcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasStatisticheLabel"><img src="img/logo_menu.png" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_statistiche.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">STATISTICHE</h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b>CHIUDI </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="transactions.php" class="dkc-selected">
                            <img src="img/ico_service.png" width="25px" class="me-3">
                            TRANSAZIONI
                        </a>
                    </h4>
                </li>
            </ul>
        </div>
    </div>
    <div class="offcanvas offcanvas-start" style="background-color: #0e1b35" tabindex="-1" id="offcanvasConfigurazione" aria-labelledby="offcanvasConfigurazioneLabel" data-bs-toggle="offcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasConfigurazioneLabel"><img src="img/logo_menu.png" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_settings.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">IMPOSTAZIONI</h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b>CHIUDI </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="commands.php">
                            <img src="img/ico_notifiche.png" width="25px" class="me-3">
                            COMANDI
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="configurations.php">
                            <img src="img/ico_portale.png" width="25px" class="me-3">
                            CONFIGURAZIONI
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="errors.php">
                            <img src="img/ico_error.png" width="25px" class="me-3">
                            ERRORI
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="network.php">
                            <img src="img/ico_network.png" width="25px" class="me-3">
                            RETE
                        </a>
                    </h4>
                </li>
            </ul>
        </div>
    </div>
    <div class="smartphone-padding d-none d-md-block"></div>
    <!-- ################################# FINE MENU MOBILE ################################################ -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container-fluid mt-1 ms-auto">
            <!-- ################################# INIZIO PAGINA ################################################ -->
            <div class="row ms-2">
                <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-0">
                    <div class="d-flex align-items-start">
                        <div class="col d-flex align-items-start">
                            <img src="img/icon_title.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <h3 class="bold" style="color:#d91a15; font-weight:900;">TRANSAZIONI</h3>
                        </div>
                        <div class="col d-flex justify-content-end">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-1 ms-2 rounded shadow-sm py-2">
                <div class="col mt-1">
                    <table class="table table-light table-sm table-responsive table-striped table-hover text-break">
                        <thead class="thead-dark">
                            <tr>
                                <th>id</th>
                                <th>data</th>
                                <th>numero carta RFID</th>
                                <th>nome carta</th>
                                <th>stato E.CHARGER</th>
                                <th>ora inizio</th>
                                <th>ora fine</th>
                                <th>durata</th>
                                <th>energia immessa kWh</th>
                                <th>errori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            ##################### QUERY SQL TRANSAZIONI #####################
                            $sql = "SELECT transactions.id, transactions.tempo, cards.card_no, cards.name, cards.status AS cardstatus, transactions.status, transactions.start_time, transactions.end_time, transactions.duration, transactions.delivered_kwh, transactions.error FROM transactions JOIN cards ON transactions.card_no=cards.id ORDER BY transactions.id DESC";
                            if ($stmt = mysqli_prepare($link, $sql)) {
                                if (mysqli_stmt_execute($stmt)) {
                                    $result = $stmt->get_result();
                                    $nrows = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row['cardstatus'] == 'disabled') {
                                            continue;
                                        }
                                        $nrows++;
                                        if ($row['status'] == 0) {
                                            $row['status'] = 'PRONTO';
                                        } else if ($row['status'] == 1) {
                                            $row['status'] = 'CONNESSO';
                                        } else if ($row['status'] == 2) {
                                            $row['status'] = 'IN CARICA';
                                        } else if ($row['status'] == 3) {
                                            $row['status'] = 'LOCKED';
                                        } else {
                                            $row['status'] = 'ERRORE';
                                        }
                                        $row['duration'] = sprintf('%02d:%02d:%02d', ($row['duration'] / 3600), ($row['duration'] / 60 % 60), $row['duration'] % 60);
                                        $row['delivered_kwh'] = number_format(($row['delivered_kwh'] / 1000), 2);
                                        echo "<tr><td>" . $row['id'] . "</td><td>" . $row['tempo'] . "</td><td>" . $row['card_no'] . "</td><td>" . $row['name'] . "</td><td>" . $row['status'] . "</td><td>" . $row['start_time'] . "</td><td>" . $row['end_time'] . "</td><td>" . $row['duration'] . "</td><td>" . $row['delivered_kwh'] . "</td><td>" . $row['error'] . "</td></tr>";
                                    }
                                    if ($nrows == 0) {
                                        echo "<tr><td>nessuna TRANSAZIONE trovata</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                                    }
                                } else {
                                    echo "Something went wrong. Please try again later. ";
                                }
                                mysqli_stmt_close($stmt);
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </main>
    <!-- ################################# INIZIO MENU FOOTER MOBILE ################################################ -->
    <footer class="footer d-md-none">
        <div class="container">
            <div class="row text-center">
                <div class="col text-white">
                    <img src="img/ico_overview.png" width="25px" class="me-2" alt="" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFunzioni" aria-controls="offcanvasFunzioni">
                </div>
                <div class="col text-white">
                    <img src="img/ico_statistiche.png" width="25px" class="me-2" alt="" data-bs-toggle="offcanvas" data-bs-target="#offcanvasStatistiche" aria-controls="offcanvasStatistiche">
                </div>
                <div class="col text-white">
                    <img src="img/ico_settings.png" width="25px" class="me-2" alt="" data-bs-toggle="offcanvas" data-bs-target="#offcanvasConfigurazione" aria-controls="offcanvasConfigurazione">
                </div>
            </div>
        </div>
    </footer>
    <!-- ################################# FINE MENU FOOTER MOBILE ################################################ -->

    <script src="js/jquery.slim.min.js"></script>
    <script>
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!--# endif -->

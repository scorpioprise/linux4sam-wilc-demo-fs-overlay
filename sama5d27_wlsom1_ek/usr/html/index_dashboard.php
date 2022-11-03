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
//include_once "loader.php";
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
    <title>DKC E.CHARGER | DASHBOARD SISTEMA</title>
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
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="dropdown me-2">
            <button type="button" class="btn btn-sm dropdown-toggle" style="background-color:#d91a15; color:#fff;" id="dropdownUser" data-bs-toggle="dropdown" data-toggle="tooltip" data-bs-placement="left" title="<?php echo htmlspecialchars($utente); ?>">
                <img src="img/ico_user.png" class="me-3">
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item active">HOME</a></li>
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
                            <a href="index_dashboard.php" class="dkc-selected">
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
                            <a href="transactions.php">
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
                        <a href="index_dashboard.php" class="dkc-selected">
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
                        <a href="transactions.php">
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
                            COMMANDI
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
                            <h3 class="bold" style="color:#d91a15; font-weight:900;">DASHBOARD SISTEMA</h3>
                        </div>
                        <div class="col d-flex justify-content-end">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /////////////////////////////////////// INFO ////////////////////////////////////////////////////////// -->
            <div class="row mt-1 ms-2 rounded shadow-sm py-2">
                <div class="col mt-1">
                    <table class="table table-light table-sm table-responsive table-hover text-break">
                        <thead class="thead-dark">
                            <tr>
                                <th>dati</th>
                                <th class="text-end">valori</th>
                                <th class="text-start">unita'</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>DATA SERVER</td>
                                <td class="text-end">
                                    <script>
                                        var dataServer = new Date('<!--#  echo var="timestamp" -->' * 1000);
                                        document.write(dataServer.toISOString());
                                    </script>
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr class="d-none">
                                <td>DATA E.CHARGER</td>
                                <td class="text-end">
                                    <!--#  echo var="timewallbox" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr>
                                <td>MAC ADDRESS</td>
                                <td class="text-end">
                                    <!--#  echo var="macaddress" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr class="d-none">
                                <td>ID INSTALLAZIONE</td>
                                <td class="text-end">
                                    <!--#  echo var="idimpianto" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr>
                                <td>PRODUTTORE</td>
                                <td class="text-end">
                                    <!--#  echo var="costruttore" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr class="d-none">
                                <td>CONFIGURAZIONE MACCHINA</td>
                                <td class="text-end">
                                    <!--#  echo var="configurazione" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr>
                                <td>POTENZA NOMINALE CONTATORE</td>
                                <td class="text-end">
                                  <script>
                                      var contatore = '<!--#  echo var="potenzanominalecontatore" -->';
                                      document.write(contatore.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ","));
                                  </script>
                                </td>
                                <td class="text-start"> W</td>
                            </tr>
                            <tr>
                                <td>INDIRIZZO MODBUS</td>
                                <td class="text-end">
                                    <!--#  echo var="indirizzomodbus" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr>
                                <td>INDIRIZZO IP LOCALE LAN</td>
                                <td class="text-end">
                                    <!--#  echo var="indirizzoiplocale" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr>
                                <td>INDIRIZZO IP LOCALE Wi-Fi</td>
                                <td class="text-end">
                                    <!--#  echo var="indirizzoipwlan" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr class="d-none">
                                <td>DATAE</td>
                                <td class="text-end">
                                    <!--#  echo var="dataora" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr>
                                <td>LINGUA</td>
                                <td class="text-end">
                                    <!--#  echo var="lingua" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr>
                                <td>FREQUENZA INVIO VALORI REAL TIME</td>
                                <td class="text-end">
                                    <!--#  echo var="frequenzainviorealtime" -->
                                </td>
                                <td class="text-start"> s</td>
                            </tr>
                            <tr>
                                <td>TIPOLOGIA E.CHARGER</td>
                                <td class="text-end">
                                  <script>
                                      var tipologia = '<!--#  echo var="tipologiawallbox" -->';
                                      if (tipologia == 0) {
                                          document.write('MONOFASE | CAVO');
                                      } else if (tipologia == 1) {
                                          document.write('TRIFASE | CAVO');
                                      } else if (tipologia == 2) {
                                          document.write('MONOFASE | PRESA');
                                      } else if (tipologia == 3) {
                                          document.write('TRIFASE | PRESA');
                                      } else if (tipologia == 4) {
                                          document.write('MONOFASE | CAVO | MID');
                                      } else if (tipologia == 5) {
                                          document.write('TRIFASE | CAVO | MID');
                                      } else if (tipologia == 6) {
                                          document.write('MONOFASE | PRESA | MID');
                                      } else if (tipologia == 7) {
                                          document.write('TRIFASE | PRESA | MID');
                                      } else if (tipologia == 8) {
                                          document.write('MONOFASE | CAVO | SIM');
                                      } else if (tipologia == 9) {
                                          document.write('TRIFASE | CAVO | SIM');
                                      } else if (tipologia == 10) {
                                          document.write('MONOFASE | PRESA | SIM');
                                      } else if (tipologia == 11) {
                                          document.write('TRIFASE | PRESA | SIM');
                                      } else if (tipologia == 12) {
                                          document.write('MONOFASE | CAVO | MID | SIM');
                                      } else if (tipologia == 13) {
                                          document.write('TRIFASE | CAVO | MID | SIM');
                                      } else if (tipologia == 14) {
                                          document.write('MONOFASE | PRESA | MID | SIM');
                                      } else if (tipologia == 15) {
                                          document.write('TRIFASE | PRESA | MID | SIM');
                                      };
                                  </script>
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr class="d-none">
                                <td>ID E.CHARGER</td>
                                <td class="text-end">
                                    <!--#  echo var="idwallbox" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr>
                                <td>NUMERO DI SERIE</td>
                                <td class="text-end">
                                    <!--#  echo var="numeroserie" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr>
                                <td>VERSIONE FIRMWARE</td>
                                <td class="text-end">
                                    <!--#  echo var="versionefw" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr>
                                <td>VERSIONE SOFTWARE</td>
                                <td class="text-end">
                                    <!--#  echo var="versionesw" -->
                                </td>
                                <td class="text-start"></td>
                            </tr>
                            <tr>
                                <td>POTENZA DI TARGA</td>
                                <td class="text-end">
                                  <script>
                                      var potenza = '<!--#  echo var="potenzatarga" -->';
                                      document.write(potenza.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ","));
                                  </script>
                                </td>
                                <td class="text-start"> W</td>
                            </tr>
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

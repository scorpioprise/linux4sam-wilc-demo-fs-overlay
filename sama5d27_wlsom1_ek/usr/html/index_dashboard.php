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
if (trovaLingua() == 'it') {
    include "inc/l_it.php";
} else if (trovaLingua() == 'en') {
    include "inc/l_en.php";
} else if (trovaLingua() == 'ru') {
    include "inc/l_ru.php";
}
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
<html lang="en">

<head>
    <title><?= _TITLESYSTEM ?></title>
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
                <li><a class="dropdown-item active"><?= _MENUHOME ?></a></li>
                <!--<li><a class="dropdown-item" href="change_password.php">CHANGE PASSWORD</a></li>-->
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-primary" href="logout.php"><?= _MENULOGOUT ?></a></li>
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
                            <?= _MENUOVERVIEW ?>
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="index_dashboard.php" class="dkc-selected">
                                <img src="img/ico_wallbox.png" width="25px" class="me-3">
                                <?= _MENUECHARGER ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="telemetry.php">
                                <img src="img/ico_inverter.png" width="25px" class="me-3">
                                <?= _MENUTELEMETRY ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="cards.php">
                                <img src="img/ico_card.png" width="25px" class="me-3">
                                <?= _MENURFIDCARDS ?>
                            </a>
                        </div>
                    </li>
                    <hr class="border border-secondary border-1 opacity-75 ms-2">
                    <li class="list-group-item bg-dkcenergy">
                        <h5 class="fw-bolder" style="color:#b0b0b0;">
                            <img src="img/ico_statistiche.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <?= _MENUSTATISTICS ?>
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="transactions.php">
                                <img src="img/ico_service.png" width="25px" class="me-3">
                                <?= _MENUTRANSACTIONS ?>
                            </a>
                        </div>
                    </li>
                    <hr class="border border-secondary border-1 opacity-75 ms-2">
                    <li class="list-group-item bg-dkcenergy">
                        <h5 class="fw-bolder" style="color:#b0b0b0;">
                            <img src="img/ico_settings.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <?= _MENUSETTINGS ?>
                        </h5>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="commands.php">
                                <img src="img/ico_notifiche.png" width="25px" class="me-3">
                                <?= _MENUCOMMANDS ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="configurations.php">
                                <img src="img/ico_portale.png" width="25px" class="me-3">
                                <?= _MENUCONFIGURATIONS ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="errors.php">
                                <img src="img/ico_error.png" width="25px" class="me-3">
                                <?= _MENUERRORS ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="network.php">
                                <img src="img/ico_network.png" width="25px" class="me-3">
                                <?= _MENUNETWORK ?>
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
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_overview.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUOVERVIEW ?></h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b><?= _MENUCLOSE ?> </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="index_dashboard.php" class="dkc-selected">
                            <img src="img/ico_wallbox.png" width="25px" class="me-3">
                            <?= _MENUECHARGER ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="telemetry.php">
                            <img src="img/ico_inverter.png" width="25px" class="me-3">
                            <?= _MENUTELEMETRY ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="cards.php">
                            <img src="img/ico_card.png" width="25px" class="me-3">
                            <?= _MENUTELEMETRY ?>
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
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_statistiche.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUSTATISTICS ?></h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b><?= _MENUCLOSE ?> </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="transactions.php">
                            <img src="img/ico_service.png" width="25px" class="me-3">
                            <?= _MENUTRANSACTIONS ?>
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
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_settings.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUSETTINGS ?></h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <b><?= _MENUCLOSE ?> </b><button type="button" class="btn-close btn-close-white text-reset my-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="commands.php">
                            <img src="img/ico_notifiche.png" width="25px" class="me-3">
                            <?= _MENUCOMMANDS ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="configurations.php">
                            <img src="img/ico_portale.png" width="25px" class="me-3">
                            <?= _MENUCONFIGURATIONS ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="errors.php">
                            <img src="img/ico_error.png" width="25px" class="me-3">
                            <?= _MENUERRORS ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="network.php">
                            <img src="img/ico_network.png" width="25px" class="me-3">
                            <?= _MENUNETWORK ?>
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
                            <h3 class="bold text-dkc"><?= _HEAD  ?></h3>
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
                                <th><?= _TABLEDATA ?></th>
                                <th class="text-end"><?= _TABLEVALUE ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= _TABLESERVERCOMM ?></td>
                                <td class="text-end" id="echargerdate">
                                    <script>
                                        var dataServer = new Date('<!--#  echo var="timestamp" -->' * 1000);
                                        document.getElementById("echargerdate").innerHTML = dataServer.toISOString();
                                    </script>
                                </td>
                            </tr>
                            <tr class="d-none">
                                <td>E.CHARGER DATE</td>
                                <td class="text-end">
                                    <!--#  echo var="timewallbox" -->
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLEMACADDRESS ?></td>
                                <td class="text-end">
                                    <!--#  echo var="macaddress" -->
                                </td>
                            </tr>
                            <tr class="d-none">
                                <td>INSTALLATION ID</td>
                                <td class="text-end">
                                    <!--#  echo var="idimpianto" -->
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLEMANUFACTURER ?></td>
                                <td class="text-end">
                                    <!--#  echo var="costruttore" -->
                                </td>
                            </tr>
                            <tr class="d-none">
                                <td>MACHINE CONFIGURATION</td>
                                <td class="text-end">
                                    <!--#  echo var="configurazione" -->
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLEMAXPOWER ?></td>
                                <td class="text-end" id="echargerpotenzacontatore">
                                    <script>
                                        var contatore = '<!--#  echo var="potenzanominalecontatore" -->';
                                        document.getElementById("echargerpotenzacontatore").innerHTML = contatore.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
                                    </script>
                                    W
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLEMODBUSADDRESS ?></td>
                                <td class="text-end">
                                    <!--#  echo var="indirizzomodbus" -->
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLELANIPADDRESS ?></td>
                                <td class="text-end">
                                    <!--#  echo var="indirizzoiplocale" -->
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLEWIFIPADDRESS ?></td>
                                <td class="text-end">
                                    <!--#  echo var="indirizzoipwlan" -->
                                </td>
                            </tr>
                            <tr class="d-none">
                                <td>DATETIME</td>
                                <td class="text-end">
                                    <!--#  echo var="dataora" -->
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLELANGUAGE ?></td>
                                <td class="text-end">
                                    <!--#  echo var="lingua" -->
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLEREALTIMESAMPLING ?></td>
                                <td class="text-end">
                                    <!--#  echo var="frequenzainviorealtime" -->
                                    s
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLEWBTYPE ?></td>
                                <td class="text-end" id="echargertipologia">
                                    <script>
                                        var tipologia = '<!--#  echo var="tipologiawallbox" -->';
                                        if (tipologia == 0) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT0 ?>";
                                        } else if (tipologia == 1) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT1 ?>";
                                        } else if (tipologia == 2) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT2 ?>";
                                        } else if (tipologia == 3) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT3 ?>";
                                        } else if (tipologia == 4) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT4 ?>";
                                        } else if (tipologia == 5) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT5 ?>";
                                        } else if (tipologia == 6) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT6 ?>";
                                        } else if (tipologia == 7) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT7 ?>";
                                        } else if (tipologia == 8) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT8 ?>";
                                        } else if (tipologia == 9) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT9 ?>";
                                        } else if (tipologia == 10) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT10 ?>";
                                        } else if (tipologia == 11) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT11 ?>";
                                        } else if (tipologia == 12) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT12 ?>";
                                        } else if (tipologia == 13) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT13 ?>";
                                        } else if (tipologia == 14) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT14 ?>";
                                        } else if (tipologia == 15) {
                                            document.getElementById("echargertipologia").innerHTML = "<?= _JAVASCRIPT15 ?>";
                                        };
                                    </script>
                                </td>
                            </tr>
                            <tr class="d-none">
                                <td>E.CHARGER ID</td>
                                <td class="text-end">
                                    <!--#  echo var="idwallbox" -->
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLESERIALNUMBER ?></td>
                                <td class="text-end">
                                    <!--#  echo var="numeroserie" -->
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLEFWVERSION ?></td>
                                <td class="text-end">
                                    <!--#  echo var="versionefw" -->
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLESWVERSION ?></td>
                                <td class="text-end">
                                    <!--#  echo var="versionesw" -->
                                </td>
                            </tr>
                            <tr>
                                <td><?= _TABLERATEDPOWER ?></td>
                                <td class="text-end" id="echargerpotenza">
                                    <script>
                                        var potenza = '<!--#  echo var="potenzatarga" -->';
                                        document.getElementById("echargerpotenza").innerHTML = potenza.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
                                    </script>
                                    W
                                </td>
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

<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$id = $_SESSION["id"];
$auth = $_SESSION["auth"];
$firstlogin = $_SESSION["firstlogin"];
$statoecharger = $_SESSION["echargerstato"];
$tipoecharger = $_SESSION["echargertipo"];
$potechager = $_SESSION["echargerpot"];
switch ($tipoecharger) {
    case '0':
    case '2':
    case '4':
    case '6':
    case '8':
    case '10':
    case '12':
    case '14':
        $fase = '1';
        $min = 1700;
        $max = 7400;
        break;
    case '1':
    case '3':
    case '5':
    case '7':
    case '9':
    case '11':
    case '13':
    case '15':
        $fase = '3';
        $min = 5100;
        $max = 22000;
        break;
    default:
        $fase = '0';
        $min = 1700;
        $max = 7400;
}
if ($firstlogin == 1) {
    header("location: change_password.php");
    exit;
}
require_once "inc/config.php";
include_once "loader.php";
if (trovaLingua() == 'it') {
    include "inc/l_it.php";
    $logo = 'logo_menu.png';
    $logocontinue = 'dkcenergyportal.png';
    $lang = 'it';
    $url = 'https://data.madein.it/ping';
} else if (trovaLingua() == 'en') {
    include "inc/l_en.php";
    $logo = 'logo_menu.png';
    $logocontinue = 'dkcenergyportal.png';
    $lang = 'en';
    $url = 'https://data.madein.it/ping';
} else if (trovaLingua() == 'ru') {
    include "inc/l_ru.php";
    $logo = 'logo_menu_dkc.png';
    $logocontinue = 'dkc.png';
    $lang = 'ru';
    $url = 'https://eoscharge.dkc.ru/ping';
} else if (trovaLingua() == 'userruen') {
    include "inc/l_ru.php";
    $logo = 'logo_menu_dkc.png';
    $logocontinue = 'dkc.png';
    $lang = 'ru';
    $url = 'https://eoscharge.dkc.ru/ping';
} else if (trovaLingua() == 'userenru') {
    include "inc/l_en-ru.php";
    $logo = 'logo_menu_dkc.png';
    $logocontinue = 'dkc.png';
    $lang = 'en';
    $url = 'https://eoscharge.dkc.ru/ping';
}
$response_toast = '';
if (isset($_POST['response'])) {
    $response = exec('issue_command ' . $_POST['parameter'] . " " . $_POST['valore']);
    if ($response == 'RESPONSE_MESSAGE_FAILED') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ko fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDKO . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_OK') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ok fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDOK . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_TODO') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDNOTAVAILABLE . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'SKIP SERIAL') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-ok fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDSKIPSERIAL . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_MESSAGE_NOT_APPLICABLE' || $response == 'RESPONSE_NO_AVAILABLE_UPDATE') {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDNOUPDATE . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    } elseif ($response == 'RESPONSE_SYSTEM_UPDATING') {
        echo "<!DOCTYPE html><html lang='it'><head><title>" . _TITLEREBOOT . "</title><meta charset='utf-8' /><meta content='IE=edge' http-equiv='X-UA-Compatible' /><meta content='width=device-width, initial-scale=1' name='viewport' />
        <link href='css/bootstrap.min.css' rel='stylesheet'><link href='css/logged.css' rel='stylesheet'><link href='favicon.ico' rel='icon' type='image/x-icon' />
        <link href='favicon.png' rel='icon' type='image/png' /></head><body class='text-center text-white bg-dkcenergy'><div class='container-fluid'><div class='row justify-content-center'><div class='col-12 col-md-6 my-5'>
        <img src='img/" . $logocontinue . "'><h3 class='display-6 my-5'>" . _REBOOTING . "</h3><div class='spinner-border text-danger' role='status'><span class='visually-hidden'>" . _REBOOTINGMESSAGE1 . "</span></div>
        <p class='mt-5'>" . _REBOOTINGMESSAGE2 . "</p><p class='text-muted'>" . _REBOOTINGMESSAGE5 . "</p></div></div></div></body></html>";
        die;
    } else {
        $response_toast = '<div class="toast align-items-center fade show bg-toast-kk fw-bold w-auto" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">
        ' . _TOASTCOMMANDERROR . '</div><button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
    }
}
##################### QUERY SQL PARAMETRI ATTUALI #####################
$sql = "SELECT * FROM configuration";
if ($stmt = mysqli_prepare($link, $sql)) {
    if (mysqli_stmt_execute($stmt)) {
        $result = $stmt->get_result();
        $nrows = 0;
        while ($row = $result->fetch_assoc()) {
            $nrows++;
            if ($row['name'] == 'meter_power_rating') {
                $form3003 = $row['value'];
                if ($form3003 == 0) {
                    $form3003 = $potechager;
                }
            } else if ($row['name'] == 'enable_fixed_power_inhibit_mid') {
                //20231030 solo per questo parametro, invertiamo il valore 0 is enable 1 is disable
                $form3006 = $row['value'];
                if ($form3006 == 'True' || $form3006 == 'true' || $form3006 == 1) {
                    $form3006 = _DISABLED;
                } else if ($form3006 == 'False' || $form3006 == 'false' || $form3006 == 0) {
                    $form3006 = _ENABLED;
                } else $form3006 = _NOTAVAILABLE;
            } else if ($row['name'] == 'has_rfid_reader') {
                $form3007 = $row['value'];
                if ($form3007 == 'True' || $form3007 == 'true' || $form3007 == 1) {
                    $form3007 = _ENABLED;
                } else if ($form3007 == 'False' || $form3007 == 'false' || $form3007 == 0) {
                    $form3007 = _DISABLED;
                } else $form3007 = _NOTAVAILABLE;
            } else if ($row['name'] == 'has_ocpp_service') {
                $form3009 = $row['value'];
                if ($form3009 == 'True' || $form3009 == 'true' || $form3009 == 1) {
                    $form3009 = _ENABLED;
                } else if ($form3009 == 'False' || $form3009 == 'false' || $form3009 == 0) {
                    $form3009 = _DISABLED;
                } else $form3009 = _NOTAVAILABLE;
            } else if ($row['name'] == 'has_modbus_service') {
                $form3010 = $row['value'];
                if ($form3010 == 'True' || $form3010 == 'true' || $form3010 == 1) {
                    $form3010 = _ENABLED;
                } else if ($form3010 == 'False' || $form3010 == 'false' || $form3010 == 0) {
                    $form3010 = _DISABLED;
                } else $form3010 = _NOTAVAILABLE;
            }
        }
        if ($nrows == 0) {
            echo "Something went wrong. Please try again later.";
        }
    } else {
        echo "Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
// 0=admin 1=installer 2=user
if ($auth == 0) {
    $utente = 'admin';
    $commands_menu = "<tr><td>" . _TABLE3009COMMANDS . "</td><td>" . $form3009 . "</td><td><form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'>
    <input type='hidden' name='parameter' value='3009'><select class='form-select form-select-sm' name='valore' required><option value=''>" . _TABLE3009SELCOMMANDS . "</option><option value='0'>" . _TABLE3009DISABLECOMMANDS . "</option><option value='1'>" . _TABLE3009ENABLECOMMANDS . "</option></select>
    </div><div class='col-4 col-sm-6'><button type='submit' name='response' class='btn btn-custom-grigio-mini btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>" . _TABLEAPPLYCOMMANDS . "</span></button></div></form></td>
    <td><button type='button' class='btn btn-custom-azzurro-mini btn-sm' data-bs-toggle='tooltip' data-bs-placement='left' data-bs-original-title='" . _HELPOCPPCOMMANDS . "'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>" . _TABLEHELPCOMMANDS . "</span></button></td></tr>
    <tr class='d-none'><td>" . _TABLE3010COMMANDS . "</td><td>" . $form3010 . "</td><td><form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'><input type='hidden' name='parameter' value='3010'>
    <select class='form-select form-select-sm' name='valore' required><option value=''>" . _TABLE3010SELCOMMANDS . "</option><option value='0'>" . _TABLE3010DISABLECOMMANDS . "</option><option value='1'>" . _TABLE3010ENABLECOMMANDS . "</option></select></div><div class='col-4 col-sm-6'>
    <button type='submit' name='response' class='btn btn-custom-grigio-mini btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>" . _TABLEAPPLYCOMMANDS . "</span></button></div></form></td><td>
    <button type='button' class='btn btn-custom-azzurro-mini btn-sm' data-bs-toggle='tooltip' data-bs-placement='left' data-bs-original-title='" . _HELPMODBUSCOMMANDS . "'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>" . _TABLEHELPCOMMANDS . "</span></button></td></tr><tr><td>" . _TABLE3017COMMANDS . "</td><td></td><td>
    <form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'><input type='hidden' name='parameter' value='3017'>
    <select class='form-select form-select-sm' name='valore' required><option value=''>" . _TABLE3017SELCOMMANDS . "</option><option value='0'>" . _TABLE3017REBOOTCOMMANDS . "</option><option value='1'>" . _TABLE3017RESTARTCOMMANDS . "</option></select></div>
    <div class='col-4 col-sm-6'><button type='submit' name='response' class='btn btn-custom-grigio-mini btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>" . _TABLEAPPLYCOMMANDS . "</span></button></div></form></td><td>
    <button type='button' class='btn btn-custom-azzurro-mini btn-sm' data-bs-toggle='tooltip' data-bs-placement='left' data-bs-original-title='" . _HELPREBOOT . "'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>" . _TABLEHELPCOMMANDS . "</span></button></td></tr>";
} elseif ($auth == 1) {
    $utente = 'installer';
    $commands_menu = "<tr><td>" . _TABLE3009COMMANDS . "</td><td>" . $form3009 . "</td><td><form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'>
    <input type='hidden' name='parameter' value='3009'><select class='form-select form-select-sm' name='valore' required><option value=''>" . _TABLE3009SELCOMMANDS . "</option><option value='0'>" . _TABLE3009DISABLECOMMANDS . "</option><option value='1'>" . _TABLE3009ENABLECOMMANDS . "</option></select>
    </div><div class='col-4 col-sm-6'><button type='submit' name='response' class='btn btn-custom-grigio-mini btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>" . _TABLEAPPLYCOMMANDS . "</span></button></div></form></td>
    <td><button type='button' class='btn btn-custom-azzurro-mini btn-sm' data-bs-toggle='tooltip' data-bs-placement='left' data-bs-original-title='" . _HELPOCPPCOMMANDS . "'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>" . _TABLEHELPCOMMANDS . "</span></button></td></tr>
    <tr class='d-none'><td>" . _TABLE3010COMMANDS . "</td><td>" . $form3010 . "</td><td><form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'><input type='hidden' name='parameter' value='3010'>
    <select class='form-select form-select-sm' name='valore' required><option value=''>" . _TABLE3010SELCOMMANDS . "</option><option value='0'>" . _TABLE3010DISABLECOMMANDS . "</option><option value='1'>" . _TABLE3010ENABLECOMMANDS . "</option></select></div><div class='col-4 col-sm-6'>
    <button type='submit' name='response' class='btn btn-custom-grigio-mini btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>" . _TABLEAPPLYCOMMANDS . "</span></button></div></form></td><td>
    <button type='button' class='btn btn-custom-azzurro-mini btn-sm' data-bs-toggle='tooltip' data-bs-placement='left' data-bs-original-title='" . _HELPMODBUSCOMMANDS . "'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>" . _TABLEHELPCOMMANDS . "</span></button></td></tr><tr><td>" . _TABLE3017COMMANDS . "</td><td></td><td>
    <form class='row g-3 me-1' action='" . ($_SERVER["PHP_SELF"]) . "' method='post'><div class='col-8 col-sm-6'><input type='hidden' name='parameter' value='3017'>
    <select class='form-select form-select-sm' name='valore' required><option value=''>" . _TABLE3017SELCOMMANDS . "</option><option value='0'>" . _TABLE3017REBOOTCOMMANDS . "</option><option value='1'>" . _TABLE3017RESTARTCOMMANDS . "</option></select></div>
    <div class='col-4 col-sm-6'><button type='submit' name='response' class='btn btn-custom-grigio-mini btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-check-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'></path></svg><span class='d-none d-lg-block'>" . _TABLEAPPLYCOMMANDS . "</span></button></div></form></td><td>
    <button type='button' class='btn btn-custom-azzurro-mini btn-sm' data-bs-toggle='tooltip' data-bs-placement='left' data-bs-original-title='" . _HELPREBOOT . "'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='d-block d-lg-none bi bi-info-circle-fill' viewBox='0 0 16 16'><path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'></path></svg><span class='d-none d-lg-block'>" . _TABLEHELPCOMMANDS . "</span></button></td></tr>";
} else {
    $utente = 'user';
    $commands_menu = "";
}
?>
<!--# if expr="$internetenabled=false" -->
<!--# include file="session.php" -->
<!--# include file="index_provisioning.php" -->
<!--# else -->
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">

<head>
    <title><?= _TITLECOMMANDS ?></title>
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
            <img src="img/<?php echo $logo ?>" width="164" height="50">
        </span>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        </button>
        <div class="dropdown me-2">
            <button type="button" class="btn btn-sm dropdown-toggle" style="background-color:#d91a15; color:#fff;" id="dropdownUser" data-bs-toggle="dropdown">
                <span data-bs-toggle="tooltip" title="<?php echo htmlspecialchars($utente); ?>" data-bs-placement="left">
                    <img src="img/ico_user.png" class="me-3">
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="index_dashboard.php"><?= _MENUHOME ?></a></li>
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
                            <a href="index_dashboard.php">
                                <img src="img/ico_wallbox.png" width="25px" class="me-3">
                                <?= _MENUECHARGER ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="telemetry.php">
                                <img src="img/ico_telemetria.png" width="25px" class="me-3">
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
                                <img src="img/ico_transazioni.png" width="25px" class="me-3">
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
                            <a href="commands.php" class="dkc-selected">
                                <img src="img/ico_comandi.png" width="25px" class="me-3">
                                <?= _MENUCOMMANDS ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="configurations.php">
                                <img src="img/ico_configurazioni.png" width="25px" class="me-3">
                                <?= _MENUCONFIGURATIONS ?>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item bg-dkcenergy" style="border: none">
                        <div class="fw-bolder ms-1" style="color:#fff;font-size:12px;">
                            <a href="errors.php">
                                <img src="img/ico_errori.png" width="25px" class="me-3">
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
    <div class="offcanvas offcanvas-start bg-dkcenergy" tabindex="-1" id="offcanvasFunzioni" aria-labelledby="offcanvasFunzioniLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasFunzioniLabel"><img src="img/<?php echo $logo ?>" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_overview.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUOVERVIEW ?></h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <button class="btn btn-link text-decoration-none text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                    <b><?= _MENUCLOSE ?> </b>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                    </svg>
                </button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="index_dashboard.php">
                            <img src="img/ico_wallbox.png" width="25px" class="me-3">
                            <?= _MENUECHARGER ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="telemetry.php">
                            <img src="img/ico_telemetria.png" width="25px" class="me-3">
                            <?= _MENUTELEMETRY ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="cards.php">
                            <img src="img/ico_card.png" width="25px" class="me-3">
                            <?= _MENURFIDCARDS ?>
                        </a>
                    </h4>
                </li>
            </ul>
        </div>
    </div>
    <div class="offcanvas offcanvas-start bg-dkcenergy" tabindex="-1" id="offcanvasStatistiche" aria-labelledby="offcanvasStatisticheLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasStatisticheLabel"><img src="img/<?php echo $logo ?>" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_statistiche.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUSTATISTICS ?></h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <button class="btn btn-link text-decoration-none text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                    <b><?= _MENUCLOSE ?> </b>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                    </svg>
                </button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="transactions.php">
                            <img src="img/ico_transazioni.png" width="25px" class="me-3">
                            <?= _MENUTRANSACTIONS ?>
                        </a>
                    </h4>
                </li>
            </ul>
        </div>
    </div>
    <div class="offcanvas offcanvas-start bg-dkcenergy" tabindex="-1" id="offcanvasConfigurazione" aria-labelledby="offcanvasConfigurazioneLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasConfigurazioneLabel"><img src="img/<?php echo $logo ?>" width="130" height="40"></h5>
        </div>
        <div class="row ms-1 mt-3 text-white flex-nowrap">
            <div class="col-8">
                <h5 class="fw-bolder" style="color:#b0b0b0;"><img src="img/ico_settings.png" width="35px" class="me-2" style="font-size:1.35em;" alt=""><?= _MENUSETTINGS ?></h5>
            </div>
            <div class="col-2 text-nowrap" style="font-size:12px">
                <button class="btn btn-link text-decoration-none text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                    <b><?= _MENUCLOSE ?> </b>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                    </svg>
                </button>
            </div>
        </div>
        <hr class="border border-secondary border-1 opacity-75 ms-2">
        <div class="offcanvas-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="commands.php" class="dkc-selected">
                            <img src="img/ico_comandi.png" width="25px" class="me-3">
                            <?= _MENUCOMMANDS ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="configurations.php">
                            <img src="img/ico_configurazioni.png" width="25px" class="me-3">
                            <?= _MENUCONFIGURATIONS ?>
                        </a>
                    </h4>
                </li>
                <li class="list-group-item bg-dkcenergy">
                    <h4 class="fw-bolder" style="color:#fff;font-size:12px;">
                        <a href="errors.php">
                            <img src="img/ico_errori.png" width="25px" class="me-3">
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
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
        <div class="container-fluid">
            <!-- ################################# INIZIO PAGINA ################################################ -->
            <div class="row">
                <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <div class="d-flex align-items-justify">
                        <div class="col d-flex align-items-start">
                            <img src="img/icon_title.png" width="35px" class="me-2" style="font-size:1.35em;" alt="">
                            <h3 class="bold text-dkc"><?= _HEADCOMMANDS . '&nbsp;' ?></h3>
                            <img id="iconaInternet" src="img/offlineLight.png">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between py-2 ms-0">
                <div class="col-7 col-md-6 col-lg-4 d-flex align-items-center me-lg-1 mb-lg-0 mb-1 text-break rounded-4 bg-grigiochiaro" style="min-height: 80px;">
                    <div class="icon-square flex-shrink-0 mt-1 me-3">
                        <img src="img/ico_comandi_grande.png">
                    </div>
                    <div>
                        <h6 class="fw-bold mt-3"><?= _MENUECHARGER ?> <span class="text-dkc"><?= $_SESSION["macaddress"] ?></span></h6>
                    </div>
                </div>
                <div class="col d-flex justify-content-end h-50">
                    <?php echo $response_toast; ?>
                </div>
            </div>
            <div class="row py-3 ms-0 rounded-4 shadow">
                <div class="row">
                    <div class="col mt-2 table-responsive">
                        <table class="table table-sm table-hover table-borderless">
                            <thead class="thead-dark">
                                <tr>
                                    <th><?= _TABLEPARAMETERCOMMANDS ?></th>
                                    <th><?= _TABLEVALUE ?></th>
                                    <th><?= _TABLEACTION ?></th>
                                    <th><?= _TABLEHELPCOMMANDS ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= _TABLE3000COMMANDS ?></td>
                                    <td id="statowallbox"><?= $statoecharger ?></td>
                                    <td>
                                        <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="col-8 col-sm-6">
                                                <input type="hidden" name="parameter" value="3000">
                                                <select class="form-select form-select-sm" name="valore" required>
                                                    <option value=""><?= _TABLE3000SELCOMMANDS ?></option>
                                                    <option value="0"><?= _TABLE3000STARTCOMMANDS ?></option>
                                                    <option value="2"><?= _TABLE3000STOPCOMMANDS ?></option>
                                                </select>
                                            </div>
                                            <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-custom-grigio-mini btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                                    </svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                        </form>
                                    </td>
                                    <td><button type="button" class="btn btn-custom-azzurro-mini btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPOPERATECOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                            </svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                                </tr>
                                <tr>
                                    <td><?= _TABLE3003COMMANDS ?></td>
                                    <td><?= $form3003 ?> W</td>
                                    <td>
                                        <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="col-8 col-sm-6">
                                                <input type="hidden" name="parameter" value="3003">
                                                <input class="form-control form-control-sm" type="number" min="<?php echo $min ?>" max="<?php echo $max ?>" step="100" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="">
                                            </div>
                                            <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-custom-grigio-mini btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                                    </svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                        </form>
                                    </td>
                                    <td><button type="button" class="btn btn-custom-azzurro-mini btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPMAXPOWERCOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                            </svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                                </tr>
                                <tr class="d-none">
                                    <td>3004 - ADD AUTHORIZED USER (swipe RFID card)</td>
                                    <td></td>
                                    <td>
                                        <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="col-8 col-sm-6">
                                                <input type="hidden" name="parameter" value="3004">
                                                <input class="form-control form-control-sm" type="number" min="0" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="" value="1" readonly>
                                            </div>
                                            <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-custom-grigio-mini btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                                    </svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                        </form>
                                    </td>
                                    <td><button type="button" class="btn btn-custom-azzurro-mini btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="help 3004"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                            </svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                                </tr>
                                <tr class="d-none">
                                    <td>3005 - REMOVE AUTHORIZED USER (swipe RFID card)</td>
                                    <td></td>
                                    <td>
                                        <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="col-8 col-sm-6">
                                                <input type="hidden" name="parameter" value="3005">
                                                <input class="form-control form-control-sm" type="number" min="0" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="" value="1" readonly>
                                            </div>
                                            <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-custom-grigio-mini btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                                    </svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                        </form>
                                    </td>
                                    <td><button type="button" class="btn btn-custom-azzurro-mini btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="help 3005"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                            </svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                                </tr>
                                <tr>
                                    <td><?= _TABLE3006COMMANDS ?></td>
                                    <td><?= $form3006 ?></td>
                                    <td>
                                        <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="col-8 col-sm-6">
                                                <input type="hidden" name="parameter" value="3006">
                                                <select class="form-select form-select-sm" name="valore" required>
                                                    <option value=""><?= _TABLE3006SELCOMMANDS ?></option>
                                                    <option value="0"><?= _TABLE3006ENABLECOMMANDS ?></option>
                                                    <option value="1"><?= _TABLE3006DISABLECOMMANDS ?></option>
                                                </select>
                                            </div>
                                            <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-custom-grigio-mini btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                                    </svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                        </form>
                                    </td>
                                    <td><button type="button" class="btn btn-custom-azzurro-mini btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPFIXEDPOWERCOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                            </svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                                </tr>
                                <tr>
                                    <td><?= _TABLE3007COMMANDS ?></td>
                                    <td><?= $form3007 ?></td>
                                    <td>
                                        <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="col-8 col-sm-6">
                                                <input type="hidden" name="parameter" value="3007">
                                                <select class="form-select form-select-sm" name="valore" required>
                                                    <option value=""><?= _TABLE3007SELCOMMANDS ?></option>
                                                    <option value="0"><?= _TABLE3007DISABLECOMMANDS ?></option>
                                                    <option value="1"><?= _TABLE3007ENABLECOMMANDS ?></option>
                                                </select>
                                            </div>
                                            <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-custom-grigio-mini btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                                    </svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                        </form>
                                    </td>
                                    <td><button type="button" class="btn btn-custom-azzurro-mini btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPRFIDREADERCOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                            </svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                                </tr>
                                <?php echo $commands_menu; ?>
                                <tr>
                                    <td><?= _TABLE3012COMMANDS ?></td>
                                    <td></td>
                                    <td>
                                        <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="col-8 col-sm-6">
                                                <input type="hidden" name="parameter" value="3012">
                                                <input class="form-control form-control-sm" type="hidden" min="0" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="" value="1" readonly>
                                                <p style="min-width:200px;"></p>
                                            </div>
                                            <div class="col-4 col-sm-6">
                                                <button class="btn btn-custom-grigio-mini btn-sm" id="aggiornamentoSw" type="button" data-bs-toggle="modal" data-bs-target="#softwareUpdate"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                                    </svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button>
                                            </div>
                                            <div class="modal fade" id="softwareUpdate" tabindex="-1" aria-labelledby="softwareUpdateLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="softwareUpdateLabel"><?= _MODALSWUPDATECOMMANDS ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"><?= _MODALSWUPDATEWARNINGCOMMANDS ?></div>
                                                        <div class="modal-footer btn-group">
                                                            <button class="btn btn-custom-grigio" type="button" data-bs-dismiss="modal"><?= _MODALNOCOMMANDS ?></button>
                                                            <button class="btn btn-custom-rosso" type="submit" name="response" value="apply"><?= _MODALYESCOMMANDS ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td><button type="button" class="btn btn-custom-azzurro-mini btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPSWUPDATECOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                            </svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                                </tr>
                                <tr class="d-none">
                                    <td><?= _TABLE3013COMMANDS ?></td>
                                    <td></td>
                                    <td>
                                        <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="col-8 col-sm-6">
                                                <input type="hidden" name="parameter" value="3013">
                                                <input class="form-control form-control-sm" type="hidden" min="0" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="" value="1" readonly>
                                                <p style="min-width:200px;"></p>
                                            </div>
                                            <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-custom-grigio-mini btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                                    </svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                        </form>
                                    </td>
                                    <td><button type="button" class="btn btn-custom-azzurro-mini btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPSENDCLOUDCOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                            </svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                                </tr>
                                <tr>
                                    <td><?= _TABLE3014COMMANDS ?></td>
                                    <td></td>
                                    <td>
                                        <form class="row g-3 me-1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="col-8 col-sm-6">
                                                <input type="hidden" name="parameter" value="3014">
                                                <input class="form-control form-control-sm" type="hidden" min="0" placeholder="<?= _TABLEINSERTVALUECOMMANDS ?>" name="valore" required="" value="1" readonly>
                                                <p style="min-width:200px;"></p>
                                            </div>
                                            <div class="col-4 col-sm-6"><button type="submit" name="response" class="btn btn-custom-grigio-mini btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                                                    </svg><span class="d-none d-lg-block"><?= _TABLEAPPLYCOMMANDS ?></span></button></div>
                                        </form>
                                    </td>
                                    <td><button type="button" class="btn btn-custom-azzurro-mini btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= _HELPERRORCOMMANDS ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-block d-lg-none bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                            </svg><span class="d-none d-lg-block"><?= _TABLEHELPCOMMANDS ?></span></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ################################# TELEMETRIA PER STATO ################################################ -->
        <div class="d-none container-fluid">
            <div class="row py-3 ms-0 rounded-4 shadow">
                <div class="row">
                    <div class="align-items-justify">
                        <div class="text-end" id="potenzacarichidomestici"> W</div>
                        <div class="text-end" id="potenzawallbox"> W</div>
                        <div class="text-end" id="corrente"> A</div>
                        <div class="text-end" id="corrente2"> A</div>
                        <div class="text-end" id="corrente3"> A</div>
                        <div class="text-end" id="tensione"> V</div>
                        <div class="text-end" id="utenteattivo"></div>
                        <div class="text-end" id="worktime"> hh:mm:ss</div>
                        <div class="text-end" id="energiacicloricarica"> kWh</div>
                        <div class="text-end" id="temperatura"> °C</div>
                    </div>
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
    <script src="js/jquery.min.js"></script>
    <script src="js/pushstream.js" type="text/javascript" language="javascript" charset="utf-8"></script>
    <script>
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
        var URL = '<?php echo $url ?>';
        var settings = {
            cache: false,
            dataType: "jsonp",
            async: true,
            crossDomain: true,
            url: URL,
            method: "GET",
            headers: {
                accept: "application/json",
                "Access-Control-Allow-Origin": "*",
            },
            statusCode: {
                200: function(response) {
                    document.getElementById("iconaInternet").src = 'img/onlineLight.png';
                    document.getElementById("aggiornamentoSw").className = "btn btn-custom-grigio-mini btn-sm";
                },
                400: function(response) {
                    document.getElementById("iconaInternet").src = 'img/offlineLight.png';
                    document.getElementById("aggiornamentoSw").className = "btn btn-custom-grigio-mini btn-sm disabled";
                },
                0: function(response) {
                    document.getElementById("iconaInternet").src = 'img/offlineLight.png';
                    document.getElementById("aggiornamentoSw").className = "btn btn-custom-grigio-mini btn-sm disabled";
                },
            },
        };
        $.ajax(settings).done(function(response) {
            //					console.log(response);
        });
        setTimeout(() => {
            $('.toast').toast('hide');
        }, 4000);
    </script>
    <script type="text/javascript" language="javascript" charset="utf-8">
        function messageReceived(text, id, channel) {
            if (channel == 'map1') {
                const obj = JSON.parse(text);
                for (var key of Object.keys(obj)) {
                    if (key == 'potenzacarichidomestici') {
                        const potenzacarichidomesticiwb = obj[key];
                        obj[key] = potenzacarichidomesticiwb + ' W';
                    }
                    if (key == 'potenzawallbox') {
                        const potenzawallboxwb = obj[key];
                        obj[key] = potenzawallboxwb + ' W';
                    }
                    if (key == 'corrente') {
                        const correntewb = obj[key];
                        obj[key] = correntewb + ' A';
                    }
                    if (key == 'corrente2') {
                        const corrente2wb = obj[key];
                        obj[key] = corrente2wb + ' A';
                    }
                    if (key == 'corrente3') {
                        const corrente3wb = obj[key];
                        obj[key] = corrente3wb + ' A';
                    }
                    if (key == 'tensione') {
                        const tensionewb = obj[key].toFixed();
                        obj[key] = tensionewb + ' V';
                    }
                    if (key == 'worktime') {
                        const tempolavoro = new Date(obj[key] * 1000).toISOString().slice(11, 19);
                        obj[key] = tempolavoro + ' hh:mm:ss';
                    }
                    if (key == 'energiacicloricarica') {
                        const energiacarica = obj[key].toFixed(2);
                        obj[key] = energiacarica + ' kWh';
                    }
                    if (key == 'temperatura') {
                        const temperaturawb = obj[key].toFixed();
                        obj[key] = temperaturawb + ' °C';
                    }
                    if (key == 'statowallbox' && obj[key] == 0) {
                        obj[key] = '<?= _ECHARGERSTATUSREADY ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSREADY ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                    } else if (key == 'statowallbox' && obj[key] == 1) {
                        obj[key] = '<?= _ECHARGERSTATUSCONNECTED ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSCONNECTED ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                    } else if (key == 'statowallbox' && obj[key] == 2) {
                        obj[key] = '<?= _ECHARGERSTATUSCHARGING ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSCHARGING ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                    } else if (key == 'statowallbox' && obj[key] == 3) {
                        obj[key] = '<?= _ECHARGERSTATUSLOCKED ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSLOCKED ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                    } else if (key == 'statowallbox' && obj[key] == 4) {
                        obj[key] = '<?= _ECHARGERSTATUSERROR ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSERROR ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                    } else if (key == 'statowallbox' && obj[key] == 5) {
                        obj[key] = '<?= _ECHARGERSTATUSCONNECTED ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSCONNECTED ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                    } else if (key == 'statowallbox' && obj[key] > 5) {
                        obj[key] = '<?= _ECHARGERSTATUSERROR ?>';
                        var statoecharger = '<?= _ECHARGERSTATUSERROR ?>';
                        $.post('set_type.php', {
                            'echargerstato': statoecharger
                        });
                    };
                    var el = document.getElementById(key).innerHTML = obj[key];
                    if (el) {
                        el.value = obj[key];
                    }
                }
            }
        };
        var pushstream = new PushStream({
            host: window.location.hostname,
            port: window.location.port,
            modes: "eventsource"
        });
        pushstream.onmessage = messageReceived;
        pushstream.addChannel('map1');
        pushstream.connect();
    </script>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!--# endif -->
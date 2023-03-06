<?php
session_start();
if (isset($_POST['echargertipo'])) {
    $_SESSION['echargertipo'] = $_POST['echargertipo'];
}
if (isset($_POST['echargerstato']) && ($_POST['echargerstato'] != $_SESSION['echargerstato'])) {
    $_SESSION['echargerstato'] = $_POST['echargerstato'];
}
if (isset($_POST['echargerpot']) && ($_POST['echargerpot'] != $_SESSION['echargerpot'])) {
    $_SESSION['echargerpot'] = $_POST['echargerpot'];
}
?>

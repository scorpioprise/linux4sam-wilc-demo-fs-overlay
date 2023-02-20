<?php
session_start();
if (isset($_POST['echargertipo'])) {
    $_SESSION['echargertipo'] = $_POST['echargertipo'];
}
if (isset($_POST['echargerstato']) && ($_POST['echargerstato'] != $_SESSION['echargerstato'])) {
    $_SESSION['echargerstato'] = $_POST['echargerstato'];
}


<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index_dashboard.php");
    exit;
}
require_once "inc/config.php";
$username = $password = "";
$username_err = $password_err = "";
$auth = "";
$firstlogin = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "inserisci il tuo username";
    } else {
        $username = trim($_POST["username"]);
    }
    if (empty(trim($_POST["password"]))) {
        $password_err = "inserisci la tua password";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password, auth, firstlogin FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $auth, $firstlogin);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $usernameSolo = strstr($username, '@', true);
                            $_SESSION["username"] = $usernameSolo;
                            $_SESSION["auth"] = $auth;
                            $_SESSION["firstlogin"] = $firstlogin;
                            $_SESSION["change"] = $password;
                            header("location: index_dashboard.php");
                        } else {
                            $password_err = "<div class='alert alert-warning' role='alert'>controlla le tue credenziali</div>";
                        }
                    }
                } else {
                    $username_err = "<div class='alert alert-warning' role='alert'>controlla le tue credenziali</div>";
                }
            } else {
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <title>DKC E.CHARGER | LOGIN</title>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
    <link href="favicon.png" rel="icon" type="image/png" />
</head>

<body class="text-center">
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <img src="img/dkcenergyportal.png">
        <h1 class="h3 my-3 fw-normal text-dkc">DKC E.CHARGER LOGIN</h1>
        <div class="form-floating <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <input type="text" name="username" class="form-control" placeholder="username" id="floatingInput" value="<?php echo $username; ?>" required>
            <label for="floatingInput">nome utente</label>
        </div>
        <div class="form-floating <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="password" class="form-control" placeholder="password" id="floatingPassword" required>
            <label for="floatingPassword">password</label>
            <span><?php echo $username_err; ?></span>
            <span><?php echo $password_err; ?></span>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">login</button>
        <p class="mt-4 text-muted">&copy; 2022 DKC Europe S.r.l.</p>
    </form>
</body>

</html>
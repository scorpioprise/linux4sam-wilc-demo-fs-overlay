<?php
session_start();
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
			header("location: index_dashboard.html");
			exit;
	}
	require_once "inc/config.php";
	$username = $password = "";
	$username_err = $password_err = "";
	$auth = "";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
	    if(empty(trim($_POST["username"]))){
	        $username_err = "please enter your username";
	    } else{
	        $username = trim($_POST["username"]);
	    }
	    if(empty(trim($_POST["password"]))){
	        $password_err = "please enter your password";
	    } else{
	        $password = trim($_POST["password"]);
	    }
	    if(empty($username_err) && empty($password_err)){
	        $sql = "SELECT id, username, password, auth FROM users WHERE username = ?";
	        if($stmt = mysqli_prepare($link, $sql)){
	            mysqli_stmt_bind_param($stmt, "s", $param_username);
	            $param_username = $username;
	            if(mysqli_stmt_execute($stmt)){
	                mysqli_stmt_store_result($stmt);
	                if(mysqli_stmt_num_rows($stmt) == 1){
	                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $auth);
	                    if(mysqli_stmt_fetch($stmt)){
	                        if(password_verify($password, $hashed_password)){
	                            session_start();
	                            $_SESSION["loggedin"] = true;
	                            $_SESSION["id"] = $id;
	                            $usernameSolo = strstr($username, '@', true);
	                            $_SESSION["username"] = $usernameSolo;
															$_SESSION["auth"] = $auth;
	                            header("location: index_dashboard.html");
	                        } else{
	                            $password_err = "<div class='alert alert-warning' role='alert'>please check your credentials</div>";
	                        }
	                    }
	                } else{
	                    $username_err = "<div class='alert alert-warning' role='alert'>please check your credentials</div>";
	                }
	            } else{
	                echo "Something went wrong. Please try again later.";
	            }
	            mysqli_stmt_close($stmt);
	        }
	    }
	    mysqli_close($link);
	}
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>DKC wallbox login</title>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/access.css" rel="stylesheet">
		<link href="favicon.ico" rel="icon" type="image/x-icon" />
		<link href="favicon.png" rel="icon" type="image/png" />
  </head>
  <body class="text-center">
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <img src="img/dkc_logo.png" width="300" height="47">
      <h1 class="h3 my-3 fw-normal">wallbox login</h1>
      <div class="form-floating <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        <input type="text" name="username" class="form-control" placeholder="username" id="floatingInput" value="<?php echo $username; ?>" required>
        <label for="floatingInput">username</label>
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

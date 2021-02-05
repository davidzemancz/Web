<?php

session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: admin.php");
    exit;
}
 
require_once("config.php");
 
$username = "";
$password = "";
$err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $err = "Chybí uživatelské jméno";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $err = "Chybí heslo";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($err)){
        $sql = "SELECT Id, Username, Password FROM users WHERE Username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $db_password);
                    if($stmt->fetch()){
                        if($db_password == $password){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: admin.php");
                        } else{
                            // Display an error message if password is not valid
                            $err = "Chybné heslo";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $err = "Chybné uživatelské jméno";
                }
            } else{
                echo "Během přihlašování nastala chyba";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta charset="UTF-8"/>
        <meta name="description" content="David Zeman - osobní web">
        <meta name="keywords" content="David Zeman, Zeman">
        <meta name="author" content="David Zeman">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>David Zeman</title>

        <link rel="icon" href="img/logo.png"/>
        <link rel="stylesheet" href="styles/login.css"/>
</head>
<body>
    <div class="login">
        <h1>David Zeman</h1>
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="username">Uživatelské jméno:</label>
                    <br/>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Heslo:</label>
                    <br/>
                    <input type="password" name="password">
                </div>
                <div class="form-group">
                    <input type="submit" value="Přihlásit se">
                </div>
                <?php
                    if($err != ""){
                        echo $err;
                    }
                ?>
        </form>
    </div>
</body>
</html>
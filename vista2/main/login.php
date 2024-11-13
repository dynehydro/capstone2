<?php
include_once 'config/config.php';
include_once 'classes/class.user.php';

// Start session to track user login status
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user = new User();

// Check if the user is already logged in
if (isset($_SESSION['user_email'])) {
    // Redirect to the appropriate page based on user access level
    if ($_SESSION['user_access'] == 'admin') {
        header("location: index.php");
    } else {
        header("location: home.php");
    }
    exit();
}

if (isset($_POST['login'])) {
    // Capture form fields directly
    $useremail = $_POST['email'];
    $password = $_POST['password'];

    // Check login credentials
    $login = $user->check_login($useremail, $password);
    
    if ($login) {
        // Get the user ID and user access level
        $user_id = $user->get_user_id($useremail); // Make sure this method retrieves the user ID
        $user_access = $user->get_user_access($user_id);
        
        // Set session variables after successful login
        $_SESSION['user_email'] = $useremail;
        $_SESSION['user_access'] = $user_access;  // Store the access level
        $_SESSION['user_id'] = $user_id;  // Store the user ID in the session
        $_SESSION['login'] = true;  // Set login status to true

        // Redirect based on user role
        if ($_SESSION['user_access'] == 'admin') {
            header("location: index.php"); // Redirect to admin dashboard if admin
        } else {
            header("location: home.php"); // Redirect to main page if regular user
        }
        exit();
    } else {
        // Error message if login fails
        $error_msg = "Wrong email or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <div class="form-box box">
            <header>Login</header>
            <hr>
            <form action="" method="POST">
                <?php if (isset($error_msg)): ?>
                    <div id="error_notif"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <div class="form-box">
                    <div class="input-container">
                        <i class="fa fa-envelope icon"></i>
                        <input class="input-field" type="email" placeholder="Email Address" name="email" required>
                    </div>
                    <div class="input-container">
                        <i class="fa fa-lock icon"></i>
                        <input class="input-field password" type="password" placeholder="Password" name="password" required>
                        <i class="fa fa-eye toggle icon"></i>
                    </div>
                    <div class="remember">
                        <input type="checkbox" class="check" name="remember_me">
                        <label for="remember">Remember me</label>
                        <span><a href="forgot.php">Forgot password</a></span>
                    </div>
                </div>
                <input type="submit" name="login" id="submit" value="Login" class="button">
                <div class="links">
                    Don't have an account? <a href="register.php">Signup Now</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const toggle = document.querySelector(".toggle"),
              input = document.querySelector(".password");
        toggle.addEventListener("click", () => {
            if (input.type === "password") {
                input.type = "text";
                toggle.classList.replace("fa-eye-slash", "fa-eye");
            } else {
                input.type = "password";
            }
        });
    </script>
</body>
</html>

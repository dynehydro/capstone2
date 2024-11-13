<?php 
include "config/config.php"; // Ensure connection to the database and session start

$error_msg = '';
$admin_code_required = "ADMIN"; // Predefined code for admin registration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password']; 
    $cpass = $_POST['cpass'];
    $role = $_POST['role'];
    $admin_code = $_POST['admin_code'] ?? ''; // Get the admin code if provided

    // Check if email already exists
    $check = "SELECT * FROM tbl_users WHERE user_email='{$email}'";
    $res = mysqli_query($conn, $check);
    $passwd = password_hash($pass, PASSWORD_DEFAULT);  // Password hashing

    if (mysqli_num_rows($res) > 0) {
        $error_msg = "This email is used, Try Another One Instead!";
    } else {
        if ($pass === $cpass) {
            $get_user_count = "SELECT COUNT(*) AS total FROM tbl_users";
            $user_count_result = mysqli_query($conn, $get_user_count);
            $user_count = mysqli_fetch_assoc($user_count_result)['total'];

            // Check if an admin code is required
            if ($role === 'admin' && $admin_code !== $admin_code_required) {
                $error_msg = "Invalid admin code.";
            } else {
                // Set role based on user count or provided role
                $final_role = ($user_count === 0) ? 'admin' : $role;

                $sql = "INSERT INTO tbl_users(user_lastname, user_firstname, user_email, user_password, user_access) 
                        VALUES('$name', '$name', '$email', '$passwd', '$final_role')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: login.php"); 
                    exit();
                } else {
                    $error_msg = "Registration failed. Please try again.";
                }
            }
        } else {
            $error_msg = "Password does not match.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">

            <header>Sign Up</header>
            <hr>

            <form action="#" method="POST">

                <?php if ($error_msg): ?>
                    <div class="message"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <div class="input-container">
                    <i class="fa fa-user icon"></i>
                    <input class="input-field" type="text" placeholder="Username" name="username" required>
                </div>

                <div class="input-container">
                    <i class="fa fa-envelope icon"></i>
                    <input class="input-field" type="email" placeholder="Email Address" name="email" required>
                </div>

                <div class="input-container">
                    <i class="fa fa-lock icon"></i>
                    <input class="input-field password" type="password" placeholder="Password" name="password" required>
                    <i class="fa fa-eye icon toggle"></i>
                </div>

                
                <div class="input-container">
                    <i class="fa fa-lock icon"></i>
                    <input class="input-field" type="password" placeholder="Confirm Password" name="cpass" required>
                    <i class="fa fa-eye icon"></i>
                </div>

                <div class="input-container">
                    <i class="fa fa-user icon"></i>
                    <select class="input-field" name="role" required onchange="toggleAdminCodeField(this)">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="input-container" id="admin-code-field" style="display: none;">
                    <i class="fa fa-lock icon"></i>
                    <input id="user_access" class="input-field" type="password" placeholder="Admin Code" name="admin_code">
                </div>

                <center><input type="submit" name="register" id="submit" value="Signup" class="btn"></center>

                <div class="links">
                    Already have an account? <a href="login.php">Sign in Now</a>
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

        function toggleAdminCodeField(select) {
        document.getElementById("admin-code-field").style.display = select.value === 'admin' ? 'block' : 'none';
        };
    </script>
</body>
</html>

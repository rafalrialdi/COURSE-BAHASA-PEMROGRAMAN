<?php 
session_start();

$error2 = $_SESSION['error2'] ?? "";
unset($_SESSION['error2']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="login-container">

        <img src="https://upload.wikimedia.org/wikipedia/id/6/62/UNPAM_logo1.png" 
        alt="Logo UNPAM" class="logo">

        <h2>LOGIN</h2>

        <form action="proses_login.php" method="POST">

            <label>username </label>
            <input type="text" name="username" placeholder="Username">

            <label>password </label>
            <input type="password" name="password" placeholder="Password">

            <button type="submit">Masuk</button>

        </form>

        <p>Belum punya akun? 
            <a href="register.php">Buat akun</a>
        </p>

       <?php if (!empty($error2)) { ?>
        <div class="overlay">
            <div class="error-box">
                <h2><?php echo $error2; ?></h2>
                <a href="login.php">Kembali Login</a>
            </div>
        </div>

        <?php } ?>

        
    </div>

</body>
</html>
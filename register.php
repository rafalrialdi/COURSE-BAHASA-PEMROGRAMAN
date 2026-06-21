<?php 
session_start();

$error = $_SESSION['error'] ?? "";
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>

    <link rel="stylesheet" href="register.css">


</head>

<body>

    <div class="register-container">

        <img src="https://upload.wikimedia.org/wikipedia/id/6/62/UNPAM_logo1.png" alt="Logo UNPAM" class="logo">

        <h2>REGISTER</h2>

        <form action="proses_register.php" method="POST">

            <label>username </label>
            <input type="text" name="username" placeholder="Masukkan Username">

            <label>password </label>
            <input type="password" name="password" placeholder="Masukkan Password">

            <label>nomor </label>
            <input type="number" name="nomor" placeholder="Masukkan Nomor">

            <label>email </label>
            <input type="email" name="email" placeholder="Masukkan Email">

            <button type="submit">Daftar</button>

        </form>

        <a href="login.php">Kembali ke Login</a>


        <?php if (!empty($error)) { ?>
        <div class="overlay">
            <div class="error-box">
                <h2><?php echo $error; ?></h2>
                <a href="register.php">Kembali ke Register</a>
            </div>
        </div>

        <?php } ?>


    </div>

</body>

</html>
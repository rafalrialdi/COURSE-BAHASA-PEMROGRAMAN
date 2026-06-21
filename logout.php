<?php

session_start();

session_destroy();

header("Location: web.php");
exit();
?>
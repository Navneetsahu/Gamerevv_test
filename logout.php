<?php
session_start();
session_destroy();
header("Location: /Game_web/pages/login.php");
exit();
?>

<?php
session_start();
unset($_SESSION["user"]);
unset($_SESSION["cart"]);
session_unset();
session_destroy();
header("location:login.php");

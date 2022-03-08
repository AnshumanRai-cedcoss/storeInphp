<?php
session_start();
unset($_SESSION["userdata"]);
unset($_SESSION["cart"]);
session_unset();
session_destroy();
header("location:login.php");

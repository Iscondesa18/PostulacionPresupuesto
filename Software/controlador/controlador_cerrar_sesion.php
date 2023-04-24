<?php
session_start();
session_destroy();
header("location:../Templates/login.php");



?>
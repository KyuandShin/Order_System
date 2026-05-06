<?php require_once 'includes/Auth.php';
Auth::logout();
header("Location: login.php");
exit();
?>
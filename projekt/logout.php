<?php

session_start();
session_destroy();
$_SESSION['success'] = "You have been successfully logged out.";
header('Location: index.php?menu=home');
exit();

?>
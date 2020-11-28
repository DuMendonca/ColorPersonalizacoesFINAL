<?php
session_start();
unset($_SESSION['idLogado']);
unset($_SESSION['nomeLogado']);
unset($_SESSION['nivelLogado']);
header("Location: login.php");
?>
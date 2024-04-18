<?php
session_start();
session_unset();
session_destroy();
header("Location: main.php"); // Перенаправляем пользователя на главную страницу
exit();
?>

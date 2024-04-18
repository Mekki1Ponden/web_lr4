<?php
session_start();

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: user_auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$uploadDir = "uploads/";

// Проверяем, существует ли загруженная фотография для текущего пользователя
$photoPath = $uploadDir . $user_id . ".jpg";
if (file_exists($photoPath)) {
    // Удаляем фотографию
    unlink($photoPath);
    echo "Фотография успешно удалена.";
} else {
    echo "Ошибка: Фотография не найдена.";
}

// После удаления фотографии перенаправляем пользователя обратно в личный кабинет
header("Location: user_profile.php");
exit();
?>

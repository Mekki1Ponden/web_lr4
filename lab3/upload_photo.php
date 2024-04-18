<?php
session_start();

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: user_auth.php");
    exit();
}

// Проверяем, был ли выбран файл
if (!isset($_FILES['photo'])) {
    echo "Ошибка: Файл не был выбран.";
    exit();
}

$user_id = $_SESSION['user_id'];
$uploadDir = "uploads/";

// Проверяем, существует ли папка uploads, если нет, создаем её
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Обрабатываем загрузку файла
$uploadFile = $uploadDir . basename($_FILES['photo']['name']);
$imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

// Проверяем размер файла
if ($_FILES['photo']['size'] > 500000) {
    echo "Ошибка: Файл слишком большой.";
    exit();
}

// Поддерживаемые форматы файлов
$allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
if (!in_array($imageFileType, $allowedTypes)) {
    echo "Ошибка: Допустимые форматы файлов - JPG, JPEG, PNG, GIF.";
    exit();
}

// Перемещаем загруженный файл
if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
    // Переименовываем загруженный файл с именем пользователя
    $newFileName = $uploadDir . $user_id . "." . $imageFileType;
    rename($uploadFile, $newFileName);
    echo "Файл успешно загружен.";
    
    // После успешной загрузки перенаправляем пользователя обратно в личный кабинет
    header("Location: user_profile.php");
    exit();
} else {
    echo "Ошибка при загрузке файла.";
}
?>

<?php
session_start();

// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Подключение к базе данных
    $connect = mysqli_connect("localhost", "root", "", "ArmoryShopDB");

    if (!$connect) {
        die("Error connect to database!");
    }

    // Получаем новый пароль из формы
    $new_password = mysqli_real_escape_string($connect, $_POST['new_password']);

    // Хешируем новый пароль
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Получаем ID пользователя из сессии
    $user_id = $_SESSION['user_id'];

    // Обновляем пароль пользователя в базе данных
    $update_sql = "UPDATE Clients SET Password='$hashed_password' WHERE ClientID='$user_id'";
    if (mysqli_query($connect, $update_sql)) {
        // Если пароль успешно изменен, перенаправляем пользователя на основную страницу
        header("Location: user_auth.php");
        exit();
    } else {
        echo "Ошибка при изменении пароля: " . mysqli_error($connect);
    }

    mysqli_close($connect);
}
?>

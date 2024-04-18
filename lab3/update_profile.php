<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: user_auth.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $firstName = $_POST['edit_firstName'];
    $lastName = $_POST['edit_lastName'];
    $email = $_POST['edit_email'];
    $phoneNumber = $_POST['edit_phoneNumber'];

    // Подключение к базе данных
    $connect = mysqli_connect("localhost", "root", "", "ArmoryShopDB");

    if (!$connect) {
        die("Error connect to database!");
    }

    // Обновление информации о пользователе в базе данных
    $update_query = "UPDATE Clients SET FirstName='$firstName', LastName='$lastName', Email='$email', PhoneNumber='$phoneNumber' WHERE ClientID='$user_id'";
    $result = mysqli_query($connect, $update_query);

    // Проверка на успешность обновления
    if ($result) {
        mysqli_close($connect);
        header("Location: user_profile.php"); // Перенаправление на страницу профиля
        exit();
    } else {
        echo "Ошибка при обновлении информации о пользователе: " . mysqli_error($connect);
    }

    mysqli_close($connect);
} else {
    header("Location: user_auth.php"); // Перенаправляем, если данные не отправлены методом POST
    exit();
}
?>

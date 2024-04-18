<?php
session_start();

// Подключение к базе данных
$connect = mysqli_connect("localhost", "root", "", "ArmoryShopDB");

if (!$connect) {
    die("Error connect to database!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $firstName = mysqli_real_escape_string($connect, $_POST['FirstName']);
    $lastName = mysqli_real_escape_string($connect, $_POST['LastName']);
    $email = mysqli_real_escape_string($connect, $_POST['Email']);
    $phoneNumber = mysqli_real_escape_string($connect, $_POST['PhoneNumber']);
    $password = password_hash($_POST['Password'], PASSWORD_DEFAULT); // Хешируем пароль

    $sql = "INSERT INTO Clients (FirstName, LastName, Email, PhoneNumber, Password) VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', '$password')";

    if (mysqli_query($connect, $sql)) {
        header("Location: user_profile.php"); // Перенаправляем на страницу профиля после успешной регистрации
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connect);
    }
}

mysqli_close($connect);
?>

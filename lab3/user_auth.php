<?php
session_start();

// Подключение к базе данных
$connect = mysqli_connect("localhost", "root", "", "ArmoryShopDB");

if (!$connect) {
    die("Error connect to database!");
}

// Инициализация переменной для сообщения об ошибке
$error_message = "";

// Авторизация клиента
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($connect, $_POST['Email']);
    $password = $_POST['Password'];

    $sql = "SELECT * FROM Clients WHERE Email='$email'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['Password'])) { // Проверяем хэшированный пароль
            $_SESSION['user_id'] = $row['ClientID'];
            $_SESSION['email'] = $row['Email'];
            header("Location: user_profile.php"); // Перенаправляем на страницу профиля
            exit();
        } else {
            $error_message = "Неверный пароль.";
        }
    } else {
        $error_message = "Пользователь с указанной почтой не найден.";
    }
}

mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Вход</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="Email" required>
                </div>
                <div class="input-group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="Password" required placeholder="<?php echo $error_message; ?>">
                </div>
                <button type="submit" name="login">Войти</button>
                <a href="main.php" class="return-button">Вернуться на главную</a>
                <a href="register.php" class="return-button">Зарегистрироваться</a>
            </form>
        </div>
    </div>
</body>
</html>

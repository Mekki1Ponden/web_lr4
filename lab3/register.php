<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="stylesss.css">
</head>
<body>
    <div class="container">
        <div class="registration-box">
            <h2>Регистрация</h2>
            <form action="registration_handler.php" method="post">
                <div class="input-group">
                    <label for="first-name">Имя:</label>
                    <input type="text" id="first-name" name="FirstName" required>
                </div>
                <div class="input-group">
                    <label for="last-name">Фамилия:</label>
                    <input type="text" id="last-name" name="LastName" required>
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="Email" required>
                </div>
                <div class="input-group">
                    <label for="phone-number">Номер телефона:</label>
                    <input type="tel" id="phone-number" name="PhoneNumber" required>
                </div>
                <div class="input-group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="Password" required>
                </div>
                <button type="submit" name="register">Зарегистрироваться</button>
                <a href="main.php" class="return-button">Вернуться на главную</a>
            </form>
        </div>
    </div>
</body>
</html>

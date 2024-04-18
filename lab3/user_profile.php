<?php
session_start();

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: user_auth.php");
    exit();
}

// Подключение к базе данных
$connect = mysqli_connect("localhost", "root", "", "ArmoryShopDB");

if (!$connect) {
    die("Error connect to database!");
}

$user_id = $_SESSION['user_id'];

// Получение информации о пользователе из базы данных
$sql = "SELECT * FROM Clients WHERE ClientID='$user_id'";
$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $firstName = $row['FirstName'];
    $lastName = $row['LastName'];
    $email = $row['Email'];
} else {
    echo "Ошибка: Пользователь не найден.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="stylesprofile.css">
</head>
<body>
<header>
    <div class="header-container">
        <h1>Действия</h1>
        <nav>
            <ul>
                <li> <button id="changePasswordBtn">Изменить пароль</button></li>
                <li><button id="uploadPhotoBtn">Загрузить фотографию</button></li>
                <li><a href="delete_photo.php">Удалить фотографию</a></li>
                <li><a href="cart.php">Корзина</a></li>
                <li><a href="logout.php">Выйти</a></li>
            </ul>
        </nav>
    </div>
</header>
<div class="container">
    <h2>Личный кабинет</h2>
    
    <div class="userprofile">
        <!-- Фотография профиля -->
        <div class="profile-photo">
            <?php
            // Путь к папке, где сохраняются загруженные фотографии
            $uploadDir = "uploads/";

            // Проверяем, есть ли загруженная фотография для текущего пользователя
            $photoPath = $uploadDir . $user_id . ".jpg";
            if (file_exists($photoPath)) {
                echo "<img src='$photoPath' alt='Фотография пользователя' class='profile-photo'>";
            }
            ?>
        </div>

        <!-- Информация о пользователе -->
        <div class="user-info">
            <p><strong>Имя:</strong> <?php echo $firstName . " " . $lastName; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Номер телефона:</strong> <?php echo $row['PhoneNumber']; ?></p>
        </div>
    </div>

    <!-- Кнопка "Изменить информацию" -->
    <button id="editProfileBtn">Изменить информацию</button>

    <!-- Форма редактирования информации о клиенте -->
    <form id="editProfileForm" action="update_profile.php" method="post" style="display: none;">
        <label for="edit_firstName">Имя:</label><br>
        <input type="text" id="edit_firstName" name="edit_firstName" value="<?php echo $firstName; ?>" required><br>
        <label for="edit_lastName">Фамилия:</label><br>
        <input type="text" id="edit_lastName" name="edit_lastName" value="<?php echo $lastName; ?>" required><br>
        <label for="edit_email">Email:</label><br>
        <input type="email" id="edit_email" name="edit_email" value="<?php echo $email; ?>" required><br>
        <label for="edit_phoneNumber">Номер телефона:</label><br>
        <input type="text" id="edit_phoneNumber" name="edit_phoneNumber" value="<?php echo $row['PhoneNumber']; ?>" required><br>
        <button type="submit">Подтвердить</button>
        <button type="button" class="cancel">Отмена</button>
    </form>

    <!-- Блок кнопок -->
    <div class="buttons">
        <!-- Форма изменения пароля -->
       
        <form id="changePasswordForm" action="change_password.php" method="post" style="display: none;">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <label for="new_password">Новый пароль:</label><br>
            <input type="password" id="new_password" name="new_password" required maxlength="255"><br>
            <button type="submit">Подтвердить пароль</button>
            <button type="button" class="cancel">Отмена</button>
        </form>
        
        <!-- Загрузка фотографии -->
        
        <form id="uploadPhotoForm" action="upload_photo.php" method="post" enctype="multipart/form-data" style="display: none;">
            <label for="photo">Выберите файл:</label><br>
            <input type="file" id="photo" name="photo"><br>
            <button type="submit">Загрузить</button>
            <button type="button" class="cancel">Отмена</button>
        </form>
        
        <!-- Удаление фотографии -->
       <!-- <form action="delete_photo.php" method="post">
        <button type="submit" name="delete_photo" class="delete-photo-btn">Удалить фотографию</button>
        </form> -->
    </div>

    <!-- Список купленных товаров -->
    <div class="purchases-list">
        <h3>Список купленных товаров</h3>
        <table>
            <thead>
                <tr>
                    <th>Название товара</th>
                    <th>Количество</th>
                    <th>Удалить</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Получение списка купленных товаров текущим пользователем
                $purchase_query = "SELECT Products.ProductName, Cart.Quantity, Cart.CartID
                                   FROM Cart
                                   INNER JOIN Products ON Cart.ProductID = Products.ProductID
                                   WHERE Cart.UserID = '$user_id'";
                $purchase_result = mysqli_query($connect, $purchase_query);
                while ($purchase_row = mysqli_fetch_assoc($purchase_result)) {
                    echo "<tr>";
                    echo "<td>" . $purchase_row['ProductName'] . "</td>";
                    echo "<td>" . $purchase_row['Quantity'] . "</td>";
                    echo "<td>
                            <form action='' method='post'>
                                <input type='hidden' name='cart_id' value='" . $purchase_row['CartID'] . "'>
                                <button type='submit' name='remove_purchase'>Удалить</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById("changePasswordBtn").addEventListener("click", function() {
        var form = document.getElementById("changePasswordForm");
        form.style.display = form.style.display === "none" ? "block" : "none";
    });

    document.querySelector("#changePasswordForm .cancel").addEventListener("click", function() {
        var form = document.getElementById("changePasswordForm");
        form.style.display = "none";
    });

    document.getElementById("uploadPhotoBtn").addEventListener("click", function() {
        var form = document.getElementById("uploadPhotoForm");
        form.style.display = form.style.display === "none" ? "block" : "none";
        createUploadsFolder(); // Вызываем функцию для создания папки uploads
    });

    document.querySelector("#uploadPhotoForm .cancel").addEventListener("click", function() {
        var form = document.getElementById("uploadPhotoForm");
        form.style.display = "none";
    });

    document.getElementById("editProfileBtn").addEventListener("click", function() {
        var form = document.getElementById("editProfileForm");
        form.style.display = form.style.display === "none" ? "block" : "none";
    });

    document.querySelector("#editProfileForm .cancel").addEventListener("click", function() {
        var form = document.getElementById("editProfileForm");
        form.style.display = "none";
    });

    // Функция для создания папки uploads
    function createUploadsFolder() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "create_folder.php", true);
        xhr.send();
    }
</script>
</body>
</html>

<?php
// Удаление покупки
if (isset($_POST['remove_purchase'])) {
    $cart_id = $_POST['cart_id'];
    $delete_query = "DELETE FROM Cart WHERE CartID = '$cart_id'";
    mysqli_query($connect, $delete_query);
}
mysqli_close($connect);
?>

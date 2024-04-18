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

// Добавление товаров в корзину в сессию
if(isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product'];
    $quantity = $_POST['quantity'];
    
    // Проверяем, есть ли уже товар в корзине
    if(isset($_SESSION['cart'][$product_id])) {
        // Если товар уже есть в корзине, увеличиваем количество
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        // Если товара нет в корзине, добавляем его
        $_SESSION['cart'][$product_id] = $quantity;
    }
    // Перенаправляем обратно на страницу корзины
    //header("Location: cart.php");
    //exit();
}

// Удаление товара из корзины
if(isset($_POST['remove_item'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    //header("Location: cart.php");
    //exit();
}

// Оформление заказа
$checkout_message = "";
if(isset($_POST['checkout'])) {
    // Проход по товарам в корзине и запись их в базу данных
    foreach($_SESSION['cart'] as $product_id => $quantity) {
        $insert_query = "INSERT INTO cart (UserID, ProductID, Quantity) VALUES ('$user_id', '$product_id', '$quantity')";
        mysqli_query($connect, $insert_query);
    }
    
    // Очистка корзины в сессии после оформления заказа
    unset($_SESSION['cart']);
    
    // Сообщение о успешном оформлении заказа
    $checkout_message = "Заказ успешно создан!";
    //header("Location: cart.php");
    //exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link rel="stylesheet" href="styles_cart.css">
</head>
<body>
    <div class="container">
        <h2>Корзина</h2>
        
        <p><strong>Имя:</strong> <?php echo $firstName . " " . $lastName; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        
        <!-- Кнопка возврата на страницу личного кабинета -->
        <a href="user_profile.php" class="button">Вернуться в личный кабинет</a>
        
        <!-- Форма для добавления товара в корзину -->
        <form action="" method="post">
            <label for="product">Товар:</label>
            <select name="product" id="product">
                <?php
                // Вывод списка товаров из базы данных
                $query = "SELECT * FROM Products";
                $result = mysqli_query($connect, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['ProductID'] . "'>" . $row['ProductName'] . " ($" . $row['Price'] . ")</option>";
                }
                ?>
            </select>
            <label for="quantity">Количество:</label>
            <input type="number" name="quantity" id="quantity" value="1" min="1" required>
            <button type="submit" name="add_to_cart">Добавить в корзину</button>
        </form>
        
        <!-- Кнопка оформления заказа -->
        <form action="" method="post">
            <button type="submit" name="checkout">Оформить заказ</button>
        </form>
        
        <!-- Вывод сообщения об успешном оформлении заказа -->
        <p><?php echo $checkout_message; ?></p>
        
        <!-- Вывод товаров из корзины -->
        <table>
            <thead>
                <tr>
                    <th>Название товара</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th>Удалить</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Вывод содержимого корзины из сессии
                if(isset($_SESSION['cart'])) {
                    foreach($_SESSION['cart'] as $product_id => $quantity) {
                        // Получение информации о товаре из базы данных
                        $product_query = "SELECT * FROM Products WHERE ProductID='$product_id'";
                        $product_result = mysqli_query($connect, $product_query);
                        $product_row = mysqli_fetch_assoc($product_result);
                        echo "<tr>";
                        echo "<td>" . $product_row['ProductName'] . "</td>";
                        echo "<td>$" . $product_row['Price'] . "</td>";
                        echo "<td>" . $quantity . "</td>";
                        echo "<td>$" . ($product_row['Price'] * $quantity) . "</td>";
                        // Форма для удаления товара из корзины
                        echo "<td>
                                <form action='' method='post'>
                                    <input type='hidden' name='product_id' value='" . $product_id . "'>
                                    <button type='submit' name='remove_item'>Удалить</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Ваша корзина пуста.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <!-- Вывод общей суммы -->
        <p><strong>Общая сумма:</strong> $<?php
            $total_price = 0;
            if(isset($_SESSION['cart'])) {
                foreach($_SESSION['cart'] as $product_id => $quantity) {
                    // Получение информации о товаре из базы данных
                    $product_query = "SELECT Price FROM Products WHERE ProductID='$product_id'";
                    $product_result = mysqli_query($connect, $product_query);
                    $product_row = mysqli_fetch_assoc($product_result);
                    $total_price += $product_row['Price'] * $quantity;
                }
            }
            echo $total_price;
        ?></p>
    </div>
</body>
</html>

<?php
mysqli_close($connect);
?>

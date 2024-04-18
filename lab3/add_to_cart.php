<?php
session_start();

// Проверяем, авторизован ли пользователь
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

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product'];
    $quantity = $_POST['quantity'];

    // Проверяем, есть ли уже такой товар в корзине у пользователя
    $check_query = "SELECT * FROM Cart WHERE UserID='$user_id' AND ProductID='$product_id'";
    $check_result = mysqli_query($connect, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Товар уже присутствует в корзине, обновляем количество
        $row = mysqli_fetch_assoc($check_result);
        $cart_id = $row['CartID'];
        $new_quantity = $row['Quantity'] + $quantity;
        $update_query = "UPDATE Cart SET Quantity='$new_quantity' WHERE CartID='$cart_id'";
        mysqli_query($connect, $update_query);
    } else {
        // Товара нет в корзине, добавляем новую запись
        $insert_query = "INSERT INTO Cart (UserID, ProductID, Quantity) VALUES ('$user_id', '$product_id', '$quantity')";
        mysqli_query($connect, $insert_query);
    }

    header("Location: cart.php"); // Перенаправляем обратно на страницу корзины
    exit();
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список товаров</title>
    <link rel="stylesheet" href="styless.css">
</head>
<body>
<header>
    <div class="header-container">
        <h1>В лавке у Бубыча</h1>
        <nav>
            <ul>
                <li><a href="user_auth.php">Личный кабинет</a></li>
                <li><a href="admin_profile.php">Личный кабинет админа</a></li>
                <li><a href="main.php">Главная</a></li>
            </ul>
        </nav>
    </div>
</header>
<h1>Список товаров</h1>
<div class="product-list">
    <table>
        <tr>
            <th>Фото</th>
            <th>Наименование</th>
            <th>Описание</th>
            <th><a href="?sort=price">Цена</a></th>
        </tr>
        <?php
// Подключение к базе данных
$connect = mysqli_connect("localhost", "root", "", "ArmoryShopDB");

if (!$connect) {
    die("Error connect to database!");
}

// Определение направления сортировки
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'ProductName';

// Получение списка товаров из базы данных
$sql = "SELECT * FROM Products ORDER BY $sort";
$result = mysqli_query($connect, $sql);

// Массивы с описанием и путями к изображениям
$productDescriptions = array(
    1 => "А-545 — российский автомат со сбалансированной автоматикой. Дальнейшее развитие АЕК-971. От предка его отличает, прежде всего, преломляющаяся ствольная коробка (в отличие от съёмной крышки на АЕК-971), что позволяет крепить на автомат планки Пикатинни для возможности установки различных прицелов и переключатель режима огня с обеих сторон автомата.",
    2 => "MP7 — автоматическое оружие под специально разработанный для него патрон 4,6×30 мм. MP7 скомпонован по типу небольшого пистолета-пулемёта, магазин вставляется в пистолетную рукоятку, приклад складной, телескопический, спереди имеется складная дополнительная рукоять.",
    3 => "это многокалиберная винтовка, разработанная американским подразделением SIG Sauer из серии карабинов SIG MCX. SIG MCX-SPEAR в основном под патрон .277 SIG FURY, но может быть адаптирован под 7,62 × 51 мм НАТО и 6,5 мм Creedmoor со сменой ствола.[1]",
    // Добавьте описания для остальных товаров
);

$productImages = array(
    1 => "prod/545.jpg",
    2 => "prod/mp7.jpg",
    3 => "prod/mcx300.jpg",
    // Добавьте пути к изображениям для остальных товаров
);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><img src='{$productImages[$row['ProductID']]}' alt='Product Image' width='100' height='100'></td>";
        echo "<td>{$row['ProductName']}</td>";
        echo "<td>{$productDescriptions[$row['ProductID']]}</td>";
        echo "<td>{$row['Price']}$</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Нет товаров для отображения</td></tr>";
}

mysqli_close($connect);
?>
    </table>
</div>
</body>
</html>

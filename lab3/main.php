<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница - В лавке у Бубыча</title>
    <link rel="stylesheet" href="style.css">
    <style>
      body {
  background-color: #f2f2f2; /* Приятный серый цвет фона */
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

header {
  background-color: #333; /* Темная шапка */
  border-radius: 10px; /* Закругление краев */
  padding: 20px;
  margin-bottom: 20px;
}

footer{
  background-color: #333; /* Темная шапка */
  border-radius: 10px; /* Закругление краев */
}

.header-container, .footer-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  text-align: center;
  margin: 0;
}

h1 {
  color: white;
  margin: 0;
}

nav ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

nav ul li {
  display: inline;
  margin-right: 20px;
}

nav ul li a {
  color: white;
  text-decoration: none;
}

.container {
  background-color: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.gallery-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 5x;
  margin: auto;
  max-width: 900px; /* Максимальная ширина сетки */
}

.gallery-item{
  max-width: 300px;
  max-height: 300px;
}

.gallery-item img {
  max-width: 300px;
  max-height: 300px;
  border-radius: 10px;
}

.footer-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

p{
  text-align: center;
}

/* Modal styles */
.modal {
  display: none; /* Hidden by default */
  position: absolute; /* Position it relative to the button */
  z-index: 1; /* Sit on top */
  background-color: #fefefe;
  border: 1px solid #888;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.modal-content {
  padding: 20px;
}

/* The Close Button */
.close {
  color: #aaa;
  font-size: 28px;
  font-weight: bold;
  position: absolute;
  top: 5px;
  right: 10px;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
h2{
  text-align:center;
}

#contactButton {
  background-color: #333; /* Темная шапка */
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
}

#contactButton:hover {
  background-color: #555; /* Цвет кнопки при наведении */
}
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>В лавке у Бубыча</h1>
            <nav>
                <ul>
                    <li><a href="user_auth.php">Личный кабинет</a></li>
                    <li><a href="register.php">Регистрация</a></li>
                    <li><a href="product_list.php">Список товаров</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main-content">
        <div class="container">
            <h2>Добро пожаловать в магазин оружия "В лавке у Бубыча"!</h2>
            <p>Здесь вы найдете все необходимое для вашей безопасности!</p>
            <!-- Галерея -->
            <div class="gallery-container">
                <div class="gallery-item">
                    <img src="grid/1911.jpg" alt="Image 1">
                </div>
                <div class="gallery-item">
                    <img src="grid/deagle.jpg" alt="Image 2">
                </div>
                <div class="gallery-item">
                    <img src="grid/benelli.jpg" alt="Image 3">
                </div>
                <div class="gallery-item">
                    <img src="grid/ctar.jpg" alt="Image 4">
                </div>
                <div class="gallery-item">
                    <img src="grid/val.jpg" alt="Image 5">
                </div>
                <div class="gallery-item">
                    <img src="grid/mka.jpg" alt="Image 6">
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="contact-info">
                <p style="color: white;">Контактные данные:</p>
                <p style="color: white;">Телефон: 123-456-789</p>
                <p style="color: white;">Email: example@example.com</p>
            </div>
            <button id="contactButton">Контакты</button>
        </div>
    </footer>

    <!-- Contact Modal -->
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Контактные данные:</p>
            <p>Телефон: 123-456-789</p>
            <p>Email: example@example.com</p>
        </div>
    </div>

    <script>
    // Get the modal
    var modal = document.getElementById("contactModal");

    // Get the button that opens the modal
    var btn = document.getElementById("contactButton");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
        modal.style.left = (btn.offsetLeft - modal.offsetWidth) + "px";
        modal.style.top = (btn.offsetTop - modal.offsetHeight) + "px";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>

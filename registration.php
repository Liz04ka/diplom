<?php 

require("db.php");
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {     

    // если все поля заполнены
    if (!empty($_POST['name']) && !empty($_POST['pass']) && !empty($_POST['dbpass'])) {

        $login = $_POST['name'];
        $pass = $_POST['pass'];
        $dbpass = $_POST['dbpass'];
        $role = 'abit';

        $users = $db -> query("SELECT id FROM users WHERE login='$login'")->fetchAll(PDO::FETCH_ASSOC);

        // если пароли совпадают и нет пользователя с таким именем:
        if ($pass === $dbpass && empty($users)) {

            //хеширую пароль
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT); 

            //добавляю пользователя в таблицу
            $sql = "INSERT INTO `users` (login,password,role) VALUES ('$login', '$hashedPassword', '$role')";
            $db -> query($sql);

            // получаю id этого пользователя для куки
            $user = $db -> query("SELECT * FROM users WHERE login='$login'")->fetchAll(PDO::FETCH_ASSOC);

            $user = $user[0];
            $id = $user['id'];

            setcookie('id', "$id", 0, '/');
            header('Location: /diplom/abit.php');
            die();
            
        } else {
            $error = 'Пароли не совпадают или такой логин уже сущ-т';
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Регистрация</title>
</head>
<body>

        <!-- HEADER -->
        <header class="header">
        <div class="container">

            <!-- вверхняя полоса -->
            <div class="header-up">

                <!-- логотип и название -->
                <div class="header-header">
                    <div class="header-logo">
                        <img src="img/logo.png" alt="лого ИТМО">
                    </div>

                    <h3 class="header-title">
                        Подача заявления на платное обучение
                    </h3>
                </div>

                <!-- выход -->
                <div class="header-enter">
                    <a href="enter.php" style="color: white;">Вход</a>
                </div>
            </div>

            <hr>

            <!-- нижняя полоса -->
            <div class="header-down">
                <h2 class="header-name">
                    Для работы необходимо зарегистрироваться
                </h2>
            </div>

        </div>
    </header>

    <main class="">
        <div class="registration container">

            <h2 class="reg-title aligh-center">Регистрация</h2>

            <form class="reg-form" action="#" method="post">

            <p class="form-item">
                <label for="name">Логин</label>
                <input class="form-input" type="text" id="name" name="name" value="" required>
            </p>

            <p class="form-item">
                <label for="pass">Придумайте пароль</label>
                <input class="form-input" type="password" id="name" name="pass" value="" required>
            </p>

            <p class="form-item">
                <label for="dbpass">Повторите пароль</label>
                <input class="form-input" type="password" id="name" name="dbpass" value="" required>
            </p>

            <fieldset style="border: none;">
                <label for="terms">
                    <input
                        type="checkbox"
                        id="terms"
                        name="terms"
                    >
                    Я принимаю все условия пользования
                </label>
            </fieldset>

            <button class="reg-btn form-btn blue-btn" type="submit" id="submit" disabled >Зарегистрироваться</button>

            <?php 
                if ($error) {
                    echo "<p style='color: red;'>$error</p>";
                }
            ?>
            </form>

            <p class="reg-link"> <a href="enter.php">У меня уже есть аккаунт</a></p>
        </div>
    </main>
    <script>
        const terms = document.getElementById('terms');
        const submit = document.getElementById('submit');

        terms.addEventListener('change', (e) => {
            submit.disabled = !e.currentTarget.checked;
        });
    </script>
</body>
</html>
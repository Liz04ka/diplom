<?php 

require("db.php");
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") { 


    // если у меня все поля заполнены
    if (!empty($_POST['name']) && !empty($_POST['pass'])) {

        // получаю все введенные данные
        $login = $_POST['name'];
        $pass = $_POST['pass'];

    
        // получаю пароль из бд  
        $hashpass = $db -> query("SELECT password FROM users WHERE login='$login'")->fetchColumn();
        

        // если введенный пароль совпал с тем, что из бд
        if (password_verify($pass, $hashpass)) {

            $user = $db->query("SELECT * FROM users WHERE login='$login'")->fetchAll(PDO::FETCH_ASSOC);
            $user = $user[0];

            $id = $user['id'];
    
            $request = $db -> query("SELECT * FROM requests WHERE id_abit='$id'")->fetchAll(PDO::FETCH_ASSOC);

            setcookie('id', "$id", 0, '/');
    
            // если заявки еще нет
            if (empty($request)) {
                header('Location: /diplom/abit.php');
            } else {
                header('Location: /diplom/abitstatus.php');   
            }
            die();
        } else {
            $error = "Пароль или логин не совпадают";     
        }

    } else {
        $error = "Заполните все поля"; 
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
    <title>Вход</title>
</head>
<body>

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
                    <a href="registration.php" style="color: white;">Регистрация</a>
                </div>
            </div>

            <hr>

            <!-- нижняя полоса -->
            <div class="header-down">
                <h2 class="header-name">
                    Необходимо войти в личный кабинет
                </h2>
            </div>

        </div>
    </header>

    <main class="">
        <div class="registration container">

            <h2 class="reg-title aligh-center">Вход</h2>

            <form class="reg-form" action="" method="post">

            <p class="form-item">
                <label for="name">Логин</label>
                <input class="form-input" type="text" id="name" name="name" value="" required>
            </p>

            <p class="form-item">
                <label for="pass">Пароль</label>
                <input class="form-input" type="password" id="name" name="pass" value="" required>
            </p>

            <button class="reg-btn form-btn blue-btn" type="submit" id="submit" >Войти</button>
            <?php 
                if ($error) {
                    echo "<p style='color: red;'>$error</p>";
                }
            ?>
            </form>

            <p class="reg-link"> <a href="registration.php">У меня еще нет аккаунта</a></p>
        </div>
    </main>
</body>
</html>
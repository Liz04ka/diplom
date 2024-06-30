<?php 

    //подключаемся к базе данных
    require("db.php");

    //получаем все факультеты и присваиваем результат переменной
    $course = $db->query("SELECT * FROM courses")->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Главная страница менеджера</title>
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
                        Управление договорами
                    </h3>
                </div>

                <!-- выход -->
                <div class="header-enter">
                    <a href="logout.php" style="color: white;">Выйти</a>
                </div>
            </div>

            <hr>

            <!-- нижняя полоса -->
            <div class="header-down">
                <h2 class="header-name">
                    Ефремова Елизавета Евгеньевна
                </h2>
            </div>

            

        </div>
    </header>
    
    <!-- MAIN -->
    <main class="main">
        <div class="container">

            <!-- блоки с информацией -->
            <h2 class="main-title"> Главная страница</h2>


            <!-- главные блоки -->
            <div class="main-items">

                <!-- 1 - заявки на договор -->
                <div class="main-item">
                    <h3 class="main-item_title">
                        Заявки на договор
                    </h3>

                    <div class="main-item_list">
                        <a href="request.php?id=<?php echo $course[0]['id']?>" class="main-item_list-a">ф<?php echo $course[0]['name']?></a>
                        <a href="request.php?id=<?php echo $course[1]['id']?>" class="main-item_list-a">ф<?php echo $course[1]['name']?></a>
                        <a href="request.php?id=<?php echo $course[2]['id']?>" class="main-item_list-a">ф<?php echo $course[2]['name']?></a>
                        <a href="request.php?id=<?php echo $course[3]['id']?>" class="main-item_list-a"><?php echo $course[3]['name']?></a>
                    </div>

                </div>

                <!-- 2 - Таблицы -->
                <div class="main-item">
                    <h3 class="main-item_title">
                        Информация о договорах
                    </h3>

                    <div class="main-item_list">
                        <a href="table.php?id=<?php echo $course[0]['id']?>" class="main-item_list-a"><?php echo $course[0]['name']?></a>
                        <a href="table.php?id=<?php echo $course[1]['id']?>" class="main-item_list-a"><?php echo $course[1]['name']?></a>
                        <a href="table.php?id=<?php echo $course[2]['id']?>" class="main-item_list-a"><?php echo $course[2]['name']?></a>
                        <a href="table.php?id=<?php echo $course[3]['id']?>" class="main-item_list-a"><?php echo $course[3]['name']?></a>
                    </div>

                </div>

                <!-- 3 - Оплаты -->
                <div class="main-item">
                    <h3 class="main-item_title">
                        Оплаты
                    </h3>

                    <div class="main-item_list">
                        <a href="pay.php?id=<?php echo $course[0]['id']?>" class="main-item_list-a"><?php echo $course[0]['name']?></a>
                        <a href="pay.php?id=<?php echo $course[1]['id']?>" class="main-item_list-a"><?php echo $course[1]['name']?></a>
                        <a href="pay.php?id=<?php echo $course[2]['id']?>" class="main-item_list-a"><?php echo $course[2]['name']?></a>
                        <a href="pay.php?id=<?php echo $course[3]['id']?>" class="main-item_list-a"><?php echo $course[3]['name']?></a>
                    </div>

                </div>

                <!-- 4 - Договоры -->
                <div class="main-item">
                    <h3 class="main-item_title">
                        Договоры
                    </h3>

                    <div class="main-item_list">
                        <a href="contract.php?id=<?php echo $course[0]['id']?>" class="main-item_list-a"><?php echo $course[0]['name']?></a>
                        <a href="contract.php?id=<?php echo $course[1]['id']?>" class="main-item_list-a"><?php echo $course[1]['name']?></a>
                        <a href="contract.php?id=<?php echo $course[2]['id']?>" class="main-item_list-a"><?php echo $course[2]['name']?></a>
                        <a href="contract.php?id=<?php echo $course[3]['id']?>" class="main-item_list-a"><?php echo $course[3]['name']?></a>
                    </div>

                </div>


            </div>
        </div>
    </main>

</body>
</html>
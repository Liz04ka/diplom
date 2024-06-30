<?php 
    require("db.php");

    if (empty($_COOKIE['id'])) {
        header('Location: /diplom/enter.php');
        die();
    }
    $id = $_COOKIE['id'];

    $user = $db -> query("SELECT * FROM users WHERE id='$id'")->fetchAll(PDO::FETCH_ASSOC);
    $user = $user[0];

    $request = $db -> query("SELECT * FROM requests WHERE id_abit='$id'")->fetchAll(PDO::FETCH_ASSOC);
    $request = $request[0] ?? null;
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
    <title>Подача заявки на договор</title>
</head>
<body>

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
                        Заполнение заявки на платное обучение
                    </h3>
                </div>

                <!-- выход -->
                <div class="header-enter">
                    <a href="logout.php" style="color: white;">Выйти</a>
                </div>

                <?php if (($user['role']) === 'admin') { ?> 
                        <div class="header-enter">
                            <a href="managerMain.php" style="color: white;">Я Менеджер</a>
                        </div>
                <?php } ?>  
            </div>

            

            <hr>

            <!-- нижняя полоса -->
            <div class="header-down">
                <h2 class="header-name">
                    ID: <?php echo $_COOKIE['id']?>; Логин: <?php echo $user['login']?>
                   
                </h2>
            </div>

        </div>
    </header>



    <main class="abit">
        <div class="container">
            <section class="abitItem requestItem">
                <h2>Заполните заявку</h2>

                <div class="requestItems">

                    <div class="requestItem-left">
                        <!-- форма с полями -->
                        <form action="abitform.php" method="POST">
                            <p class="form-item">
                                <label for="name">Фамилия Имя Отчество <span style="font-weight: bold;">Абитуриента</span></label>
                                <input class="form-input" type="text" id="name" name="name" value="" required>
                            </p>

                            <p class="form-item">
                                <label for="course">Факультет:</label>
                                <select class="form-input" name="course">
                                    <option value="1">Программной Инженерии и Компьютерной Техники(ПИиКТ)</option>                                    
                                    <option value="2">Безопасности Информационных Технологий(БИТ)</option>
                                    <option value="3">Систем Управления и Робототехники(СУиР)</option>
                                    <option value="4">Центр Химической Инженерии(ЦХИ)</option>
                                </select>
                            </p>


                            <p class="form-item">
                                <label for="direct">Направление подготовки</label>
                                <select class="form-input" name="direct">
                                    <option value="ПрогИнж">09.03.04 Программная инженерия</option>                                    
                                    <option value="ИВТ">09.03.01 Информатика и вычислительная техника</option>
                                </select>
                            </p>

                            <p class="form-item">
                                <label for="program">Образовательная программа</label>
                                <select class="form-input" name="program">
                                    <option value="КСИТ">Компьютерные системы и технологии</option>                                    
                                    <option value="СППО">Системное и прикладное программное обеспечение</option>
                                    <option value="Нейротех">Нейротехнологии и рограммирование</option>                                    
                                    <option value="Дизайн">Компьютерные технологии в дизайне</option>
                                </select>
                            </p>

                            <p class="form-item">
                                <label for="name">Фамилия Имя Отчество <span style="font-weight: bold;">Заказчика</span> </label>
                                <input class="form-input" type="text" id="name" name="clientname" value="" required >
                            </p>

                            <p class="form-item">
                                <label for="name">Серия и номер паспорта</label>
                                <input class="form-input" type="text" id="name" name="passport" value="" minlength="10" maxlength="10" required >
                            </p>

                            <p class="form-item">
                                <label for="name">Кем выдан</label>
                                <input class="form-input" type="text" id="name" name="issued" value="" required >
                            </p>

                            <p class="form-item">
                                <label for="name">Номер телефона (для связи)</label>
                                <input class="form-input" type="tel" id="name" name="phone" value="" minlength="11" maxlength="11" required>
                            </p>

                            <p class="form-item">
                                <label for="name">Электронная почта (для связи)</label>
                                <input class="form-input" type="tel" id="name" name="email" value="" required>
                            </p>
    
                            <!-- <input type="hidden" id="status" name="status" value="send"> -->

                            <!-- <input type="hidden" id="status" name="id" value=""> -->

                            <?php if (empty($request) || $request['status'] === 'return') { ?>

                                <div class="form-btns">
                                    <button class="form-btn blue-btn" name="create">Отправить</button>
                                    
                                </div>

                            <?php } ?>
                        </form>
                    </div>     
                    
                    <div class="requestItem-right">
                        <h2 class="info">Обязательно ознакомтесь  с информацией о правилах заключения договора в Университете ИТМО</h2>
                        
                        <div style="margin-bottom: 20px;">Сайт Абитуриент ИТМО: <a style="text-decoration: underline;" href="https://abit.itmo.ru/bachelor">abit.itmo.ru/bachelor</a> </div>

                        <h2 class="info">Минимальные баллы ЕГЭ по трем предметам:</h2>

                        <div class="abit-img">
                            <img src="img/abit.png" alt="">
                        </div>

                        <div class="send-status">

                        <p class="status-text">
                        Для поступления на платную форму обучения <span class="bold-text"> Вам необходимо набрать минимальные баллы ЕГЭ по каждому предмету</span>. 
                        <br>
                        Это является минимальным условием для подачи заявления в университет. 
                        <br>
                        <br>

                        После этого Вы можете заключить договор на любую образовательную программу. После подписания договора, а также его оплаты Вы считаетесь зачисленным. 
                        
                        <br>
                        <br>

                        Конкурса на платное обучение нет

                        </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
<?php 
    require("db.php");
    
    $id = $_GET['id'];
    $request = $db->query("SELECT * FROM `requests` WHERE id=$id")->fetchAll(PDO::FETCH_ASSOC);
    $request = $request[0];

    $id_course = $request['id_course'];

    $contract = $db->query("SELECT number FROM `contracts` WHERE id_requests=$id")->fetchColumn();

    $course = $db->query("SELECT kod FROM `courses` WHERE id=$id_course")->fetchColumn();

    $number;

    if ($contract < 10 ) {
        $number = $course."2400".$contract;
    } else {
        if ($contract < 100 ){
            $number = $course."240".$contract;
        } else {
            $number = $course."24".$contract;
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
    <title>Заявка на договор</title>
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

    <main class="pay request">
        <div class="container">

        <section class="pages-header">

            <div class="">
                <!-- ссылка назад -->
                <a href="managerMain.php" class="backto">
                    На главную
                </a>

            </div>
                
        </section>

        <section class="requestItem">
            <h2>Логин: <?php echo $request['name']?>; ID: <?php echo $request['id_abit']?>;</h2>

            <div class="requestItems">

                <div class="requestItem-left">

                <!-- форма с полями до принятия заявки === "send" -->
                    
                    <form class="form-request" action="requestupdete.php" method="POST">
                        <p class="form-item">
                            <label for="name">Фамилия Имя Отчество Абитуриента</label>
                            <input class="form-input" type="text" id="name" name="name" value="<?php echo $request['name']?>">
                        </p>

                        <p class="form-item">
                            <label for="name">Направление подготовки</label>
                            <input class="form-input" type="text" id="name" name="np" value="<?php echo $request['direct']?>">
                        </p>

                        <p class="form-item">
                            <label for="name">Образовательная программа</label>
                            <input class="form-input" type="text" id="name" name="programm" value="<?php echo $request['program']?>">
                        </p>

                        <p class="form-item">
                            <label for="name">Фамилия Имя Отчество Заказчика</label>
                            <input class="form-input" type="text" id="name" name="clientname" value="<?php echo $request['client']?>">
                        </p>

                        <p class="form-item">
                            <label for="name">Серия и номер паспорта</label>
                            <input class="form-input" type="text" id="name" name="passport" value="<?php echo $request['passport']?>">
                        </p>

                        <p class="form-item">
                            <label for="name">Кем выдан</label>
                            <input class="form-input" type="text" id="name" name="issued" value="<?php echo $request['issued']?>">
                        </p>

                        <p class="form-item">
                            <label for="name">Номер телефона(для связи)</label>
                            <input class="form-input" type="tel" id="name" name="phone" value="<?php echo $request['phone']?>">
                        </p>

                        <p class="form-item">
                            <label for="name">Электронная почта(для связи)</label>
                            <input class="form-input" type="tel" id="name" name="email" value="<?php echo $request['email']?>">
                        </p>
 
                        <input type="hidden" id="status" name="status" value="<?php echo $request['status']?>">
                        <input type="hidden" id="status" name="id" value="<?php echo $request['id']?>">

                        <div class="form-btns">

                            <!-- если заявка не принята, то ее можно создать или внести изменения -->
                            <?php if ($request['status'] != 'accepted') { ?>
                                
                                <button class="form-btn blue-btn" name="create">Создать</button>
                                
                                <div class="form-btns">
                                    <button class="form-btn" name="change">Изменить</button>
                                </div>

                            <?php } ?>

                            <!-- если заявка принята, то ее можно только удалить -->
                            <?php if ($request['status'] === 'accepted') { ?>
                                
                                <button class="form-btn" name="delete">Удалить</button>

                            <?php } ?>
                        </div>
                    </form>

                    <?php if ($request['status'] != 'accepted') { ?>
                        <form action="comment.php" method="post">
                            <input type="hidden" id="status" name="id" value="<?php echo $request['id']?>">
                            <textarea class="textarea" name="comment" id="" cols="29" rows="5" placeholder="Комментарий для абитуриента"></textarea>
                            <button class="form-btn" name="return">Отклонить</button>
                        </form>
                    <?php } ?>
                </div>     
                
                <div class="requestItem-right">

                <!--  -->
                <?php if($request['status'] === 'accepted') { ?>

                    <h2 class="aligh-center">Договор: <?php echo $number ?></h2>

                    <div class="form-btns">
                        <a class="file" href="<?php echo $number ?>.pdf" download>Скачать</a>

                        <a class="file" href="table.php?id=<?php echo $request['id_course'] ?>">Перейти к таблице договоров</a>
                    </div>

                <?php } ?>

                </div>
            </div>
        </section>


        </div>
    </main>
</body>
</html>
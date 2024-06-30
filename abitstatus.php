<?php 
    require("db.php");

    if (empty($_COOKIE['id'])) {
        header('Location: /diplom/enter.php');
        die();
    }

    // получаю id пользователя
    $id = $_COOKIE['id'];

    // получаю всю инфу по юзеру из пользователя
    $user = $db -> query("SELECT * FROM users WHERE id='$id'")->fetchAll(PDO::FETCH_ASSOC);
    $user = $user[0];
    // print_r($user);

    //заявка по конкретному абитуриенту 
    $request = $db->query("SELECT * FROM `requests` WHERE id_abit=$id")->fetchAll(PDO::FETCH_ASSOC);
    $request = $request[0];
    
    //id заявки
    $idreq = $request['id'];

    //вся вся инфа об абитуриенте
    $abit = $db->query("SELECT * FROM payments JOIN contracts ON payments.idcontr = contracts.number JOIN requests ON requests.id = contracts.id_requests WHERE id_requests=$idreq")->fetchAll(PDO::FETCH_ASSOC);

    $abit = $abit[0] ?? null;
    // print_r($abit);

    $number = $abit['number'] ?? null;

    $success = false;

    if (!empty($_POST)) {

        $target_dir = "files/";
        $target_file = $target_dir.basename($_FILES["file"]['name']);

        $new_filename = $target_dir . "$number.pdf";

        if (move_uploaded_file($_FILES['file']['tmp_name'], $new_filename)) {
            $success = true;

            //id заявки
            // $idreq = $_POST['idrequests'];

            // $abit = $db->query("SELECT * FROM payments JOIN contracts ON payments.idcontr = contracts.number JOIN requests ON requests.id = contracts.id_requests WHERE id_requests=$idreq")->fetchAll(PDO::FETCH_ASSOC);
            // $abit = $abit[0];

            // номер договора
            

            $db->query("UPDATE payments SET pay='check' WHERE idcontr=$number")->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Статус заявки на договор</title>
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
                        Статус заявки на платное обучение
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
                    ID: <?php echo $_COOKIE['id']?>; Логин: <?php echo $user['login']?>
                </h2>
            </div>

        </div>
    </header>


    <main>
        <div class="status-page container">

            <section class="requestItem">

            <div class="requestItems">
                <!-- инфа о заявке и потом о оплате -->
                <div class="requestItem-left">
                    
                    <!-- если завка просто отправлена -->
                    <?php if ($request['status'] === 'send') { ?>
                    <div class="send-status">
                        <p class="status-text">Ваша заявка успешно отправлена. Подтверждение может занять некторое время, как только менеджер ее обработает статус на этой странице поменяется.  </p>
                    </div>
                    <?php } ?>

                    <!-- если заявка отклонена, то выводим сообщение от менеджера -->
                    <?php if ($request['status'] === 'return') { ?>

                        <div class="send-status big-margin">
                            <p class="status-text "><span class="bold-text">К сожалению, ваша заявка была отклонена. Комментарий менеджера:</span></p>
                            <p class="status-text">"<?php echo $request['comment'] ?>"</p>
                        </div>
                        

                        <a href="abit.php" class="backto">
                            Подать заявку повторно
                        </a>
                    <?php } ?>

                    <!-- заявка принята, можно оплачивать -->
                    <?php if ($request['status'] === 'accepted') { ?>
                    <div class="send-status">
                        <p class="status-text">Ваша заявка обработана. По данным из нее был составлен договор. Для зачисления Вам необходимо его подписать и оплатить. <br><br> <span class="bold-text"> Подписать очно: </span> <br> Для того, чтобы подписать экземпляры договора очно Вам необходимо прийти в приемную комиссию по адресу Кронверкский проспект, 49. Там вам предоставят договор в нескольких экземплярах для подписания и выдадут квитанцию на оплату. 
                        <br><br> <span class="bold-text"> Подписать дистанционно:</span> <br> Для того, чтобы подписать договор дистанционно, вам необходимо: <br> - Распечатать его в 3х экземплярах; <br> - Подписать на внизу на каждой странице поля "Заказчик" и "Обучающийся" <br> - Направить документы службой отправки по адресу Кронверкский проспект, 49 на имя Иванов Иван Иванович. 
                        
                        <br>
                        <br>
                        
                        Чтобы получить электронную версию договора нажмите на ссылку:
                        
                        <a href="logout.php" style="color: black;"> <span class="bold-text"> Получить договор </a>
                        
                    </p>
                    </div>
                    <div class="send-status">
                        <p class="status-text">После оплаты обязательно <span class="bold-text">прикрепите чек или квитанцию </span> ниже или отправте на почту: <span class="bold-text">ktu.contract@itmo.ru</span></p>
                    </div>

                    <?php if ($abit['pay'] === 'Нет') { ?>

                    <div class="status-file">
                        <form class="form-status" enctype="multipart/form-data" action="" method="POST">
                            <!-- <input type="hidden" name="maxsize" value="30000" /> -->
                            <input type="hidden" name="idrequests" value="<?php echo $request['id'] ?>" />
                            
                            <!-- Выберите и отправте чек или квитанцию об оплате: <input name="userfile" type="file" /> -->
                            <label class="input-file">
                                <input type="file" name="file">		
                                <span>Выберите файл</span>
                            </label>

                            <input class="file-btn" type="submit" value="Отправить" />
                        </form>

                        <?php if ($success) { ?>
                             файл успешно загружен
                        <?php } ?>
                    </div>

                    <?php } ?>
                    <?php } ?>
                </div>     
                



                <!-- форма с полями -->
                <div class="requestItem-right">
                    <h2 class="aligh-center">Данные в заявке:</h2>
                    
                    <form action="requestupdete.php" method="POST">
                        <p class="form-item">
                            <label for="name">Фамилия Имя Отчество Абитуриента</label>
                            <input class="form-input" type="text" id="name" name="name" value="<?php echo $request['name']?>" readonly>
                        </p>


                        <p class="form-item">
                            <label for="name">Направление подготовки</label>
                            <input class="form-input" type="text" id="name" name="np" value="<?php echo $request['direct']?>" readonly>
                        </p>

                        <p class="form-item">
                            <label for="name">Образовательная программа</label>
                            <input class="form-input" type="text" id="name" name="programm" value="<?php echo $request['program']?>" readonly>
                        </p>

                        <p class="form-item">
                            <label for="name">Заказчик</label>
                            <input class="form-input" type="select" id="name" name="client" value="<?php echo $request['client']?>" readonly>
                        </p>

                        <p class="form-item">
                            <label for="name">Фамилия Имя Отчество Заказчика</label>
                            <input class="form-input" type="text" id="name" name="clientname" value="<?php echo $request['client']?>" readonly>
                        </p>

                        <p class="form-item">
                            <label for="name">Серия и номер паспорта</label>
                            <input class="form-input" type="text" id="name" name="passport" value="<?php echo $request['passport']?>" readonly>
                        </p>

                        <p class="form-item">
                            <label for="name">Кем выдан</label>
                            <input class="form-input" type="text" id="name" name="issued" value="<?php echo $request['issued']?>" readonly>
                        </p>

                        <p class="form-item">
                            <label for="name">Номер телефона(для связи)</label>
                            <input class="form-input" type="tel" id="name" name="phone" value="<?php echo $request['phone']?>" readonly>
                        </p>

                        <p class="form-item">
                            <label for="name">Электронная почта(для связи)</label>
                            <input class="form-input" type="tel" id="name" name="email" value="<?php echo $request['email']?>" readonly>
                        </p>
 
                        <input type="hidden" id="status" name="status" value="<?php echo $request['status']?>">
                        <input type="hidden" id="status" name="id" value="<?php echo $request['id']?>">
                        
                    </form>
                </div>
            </div>
        </section>

        </div>
    </main>

    </body>
    <script>
        document.querySelector('.input-file input[type=file]').addEventListener('change', function(){
        if(this.files.length > 0) {
            let file = this.files[0];
            this.nextElementSibling.innerHTML = file.name;
        }
        });
    </script>
</html>
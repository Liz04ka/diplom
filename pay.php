<?php 

    //подключаемся к базе данных
    require("db.php");

    $idCourse = $_GET['id'];
    $program = $_GET['program'] ?? null;
    $course = $db->query("SELECT * FROM `courses` WHERE id=$idCourse")->fetchAll(PDO::FETCH_ASSOC);

    // $idpay = null;

    if (is_null($program) || $program === 'all') {
        //получаем все факультеты и присваиваем результат переменной
        $payments = $db->query("SELECT * FROM payments")->fetchAll(PDO::FETCH_ASSOC);
        //id, date, status
        $abits = $db->query("SELECT * FROM `payments` JOIN `contracts` ON payments.idcontr = contracts.number JOIN `requests` ON contracts.id_requests = requests.id WHERE id_course=$idCourse AND status='accepted'")->fetchAll(PDO::FETCH_ASSOC);
        // print_r($abits);
        
    } else {
        //получаем все факультеты и присваиваем результат переменной
        $payments = $db->query("SELECT * FROM payments")->fetchAll(PDO::FETCH_ASSOC);
        //id, date, status
        $abits = $db->query("SELECT * FROM `payments` JOIN `contracts` ON payments.idcontr = contracts.number JOIN `requests` ON contracts.id_requests = requests.id WHERE id_course=$idCourse AND program='$program'")->fetchAll(PDO::FETCH_ASSOC);

    }

    if (!empty($_POST['idcontr'])) {
        $idcontr = $_POST['idcontr'];
        $db->query("UPDATE payments SET pay='Да' WHERE idcontr=$idcontr");
    }

    
    // $success = false;

    if (!empty($_POST['idrequests'])) {

        $number = $_POST['idrequests'];

        $target_dir = "files/";
        $target_file = $target_dir.basename($_FILES["file"]['name']);

        $new_filename = $target_dir . "$number.pdf";

        if (move_uploaded_file($_FILES['file']['tmp_name'], $new_filename)) {
            // $success = true;

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
    <title>Оплаты</title>
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

                <!-- ссылка назад -->
                <a href="managerMain.php" class="backto">
                    На главную
                </a>
                
                <!-- название страницы -->
                <h2 class="request-header_title">
                    Оплаты по договорами <?php echo $course[0]['name'] ?>
                </h2>

                <div class="filter">
                        <div class="filter-items" style="display: flex;">Сортировать:
                            <a class="filter-link" href="pay.php?id=<?php echo $idCourse.'&'.'program=Нейротех'?>">Нейротех</a>
                            <a class="filter-link" href="pay.php?id=<?php echo $idCourse.'&'.'program=СППО'?>">СППО</a>
                            <a class="filter-link" href="pay.php?id=<?php echo $idCourse.'&'.'program=Дизайн'?>">Дизайн</a>
                            <a class="filter-link" href="pay.php?id=<?php echo $idCourse.'&'.'program=ИВТ'?>">ИВТ</a>
                            <a class="filter-link" href="pay.php?id=<?php echo $idCourse.'&'.'program=all'?>">Все</a>
                        </div>
                </div>
                
            </section>

            <section class="request-table">
                <table>
                    <tr>
                      <th>№ Договора</th>
                      <th>ФИО Абитуриента</th>
                      <th>Оплата</th>
                      <th></th>
                      <th></th>
                    </tr>

                    <?php
                        foreach ($abits as $abit) {
                    ?>
                    
                    <tr>
                        <td><a class="main-item_list-a" href="requestItem.php?id=<?php echo $abit['id']?>">
                          
                          <?php
                            if ($abit['number'] < 10 ) {
                                echo $course[0]['kod']."2400".$abit['number'];
                            } else {
                                if ($abit['number'] < 100 ){
                                    echo $course[0]['kod']."240".$abit['number'];
                                } else {
                                    echo $course[0]['kod']."24".$abit['number'];
                                }
                            }?></a>
                        </td>
                      <td> <?php echo $abit['name'] ?> </td>
                      <td>
                        <!-- если статус "подтвердить", то выводится кнопка, которая меняет его на да -->
                        <?php if ($abit['pay'] === 'check') { ?>
                            <form action="" method="post">
                                <input type="hidden" name="idcontr" value="<?php echo $abit['idcontr'] ?>">
                                <button class="check-btn" type="submit" id="submit">Подтвердить</button>
                            </form>
                        <?php } else { ?> 
                            <!-- иначе просто статус из бд -->
                            <?php echo $abit['pay'] ?>
                        <?php } ?> 
                     </td>

                     <?php if($abit['pay'] != 'Нет') { ?>
                      <td><a class="" href="files/<?php echo $abit['number'] ?>.pdf" download>
                        Скачать
                      </a></td>
                      <?php } else {?>
                        <td></td>
                    <?php } ?>

                      <?php if($abit['pay'] === 'Нет') { ?>
                            <td>
                                <form class="form-pay" enctype="multipart/form-data" action="" method="POST">
                                <!-- <input type="hidden" name="maxsize" value="30000" /> -->
                                <input type="hidden" name="idrequests" value="<?php echo $abit['number'] ?>" />
                                
                                <!-- Выберите и отправте чек или квитанцию об оплате: <input name="userfile" type="file" /> -->
                                <label class="input-file-pay">
                                    <input type="file" name="file">		
                                    <span>Выбрать файл</span>
                                </label>

                                <input class="file-btn" type="submit" value="Загрузить" />
                                </form>
                            </td>
                      <?php } else {?>
                        <td></td>
                    <?php } ?>
                    </tr>      
                    
                    <?php
                        }
                    ?>
                  
                  </table>
            </section>
        </div>
    </main>
    <script>
        document.querySelector('.input-file-pay input[type=file]').addEventListener('change', function(){
        if(this.files.length > 0) {
            let file = this.files[0];
            this.nextElementSibling.innerHTML = file.name;
        }
        });
    </script>
</body>
</html>
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
        
    } else {
        //получаем все факультеты и присваиваем результат переменной
        $payments = $db->query("SELECT * FROM payments")->fetchAll(PDO::FETCH_ASSOC);
        //id, date, status
        $abits = $db->query("SELECT * FROM `payments` JOIN `contracts` ON payments.idcontr = contracts.number JOIN `requests` ON contracts.id_requests = requests.id WHERE id_course=$idCourse AND program='$program'")->fetchAll(PDO::FETCH_ASSOC);

    }

    if (!empty($_POST)) {
        $idcontr = $_POST['idcontr'];
        $db->query("UPDATE payments SET pay='Да' WHERE idcontr=$idcontr");
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
    <title>Договоры</title>
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

    <main class="request">
        <div class="container">
            <!-- на главную, название, сортировка, фильтры -->
            <section class="pages-header">

                <!-- ссылка назад -->
                <a href="managerMain.php" class="backto">
                    На главную
                </a>
                
                <!-- название страницы -->
                <h2 class="request-header_title">
                    Файлы договоров факультет ПИиКТ
                </h2>

                <div class="filter">
                    <div class="filter-items" style="display: flex;">Сортировать:
                        <a class="filter-link" href="contract.php?id=<?php echo $idCourse.'&'.'program=Нейротех'?>">Нейротех</a>
                        <a class="filter-link" href="contract.php?id=<?php echo $idCourse.'&'.'program=СППО'?>">СППО</a>
                        <a class="filter-link" href="contract.php?id=<?php echo $idCourse.'&'.'program=Дизайн'?>">Дизайн</a>
                        <a class="filter-link" href="contract.php?id=<?php echo $idCourse.'&'.'program=ИВТ'?>">ИВТ</a>
                        <a class="filter-link" href="contract.php?id=<?php echo $idCourse.'&'.'program=all'?>">Все</a>
                    </div>
                </div>
                
            </section>

            <section class="request-table">

                <div class="contract_items">

                    <?php
                        foreach ($abits as $abit) {
                    ?>
                    <div class="contract_item">
                        <a class="file" href="contracts/76224025.pdf" download>
                            Договор №
                            <?php
                            if ($abit['number'] < 10 ) {
                                echo $course[0]['kod']."2400".$abit['number'];
                            } else {
                                if ($abit['number'] < 100 ){
                                    echo $course[0]['kod']."240".$abit['number'];
                                } else {
                                    echo $course[0]['kod']."24".$abit['number'];
                                }
                            }?>
                        </a>
                    </div>

                    <?php
                        }
                    ?>
                  
                    
                </div>
            </section>
        </div>
    </main>
</body>
</html>
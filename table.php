<?php 

    require("db.php");

    $id = $_GET['id'];
    $program = $_GET['program'] ?? null;

    if (is_null($program) || $program === 'all') {
        $course = $db->query("SELECT * FROM `courses` WHERE id=$id")->fetchAll(PDO::FETCH_ASSOC);
        $abits = $db->query("SELECT * FROM `requests` JOIN `contracts` ON requests.id = contracts.id_requests WHERE id_course=$id AND status='accepted'")->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $course = $db->query("SELECT * FROM `courses` WHERE id=$id")->fetchAll(PDO::FETCH_ASSOC);
        $abits = $db->query("SELECT * FROM `requests` JOIN `contracts` ON requests.id = contracts.id_requests WHERE id_course=$id AND status='accepted' AND program='$program'")->fetchAll(PDO::FETCH_ASSOC);
    }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Таблицы заключенных договоров</title>
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

    <main class="table request">
        <div class="container">

                <!-- на главную, название, сортировка, фильтры -->
                <section class="pages-header">

                    <!-- ссылка назад -->
                    <a href="managerMain.php" class="backto">
                        На главную
                    </a>
                    
                    <!-- название страницы -->
                    <h2 class="request-header_title">
                        Договоры факультет <?php echo $course[0]['name'] ?>
                    </h2>



                    <div class="filter">
                        <div class="filter-items" style="display: flex;">Сортировать:
                            <a class="filter-link" href="table.php?id=<?php echo $id.'&'.'program=Нейротех'?>">Нейротех</a>
                            <a class="filter-link" href="table.php?id=<?php echo $id.'&'.'program=СППО'?>">СППО</a>
                            <a class="filter-link" href="table.php?id=<?php echo $id.'&'.'program=Дизайн'?>">Дизайн</a>
                            <a class="filter-link" href="table.php?id=<?php echo $id.'&'.'program=КСИТ'?>">ИВТ</a>
                            <a class="filter-link" href="table.php?id=<?php echo $id.'&'.'program=all'?>">Все</a>
                        </div>
                        <!-- <div class="filter-item">Фильтровать</div> -->
                    </div>

                </section>

                <section class="request-table">
                    <table>
                        <tr>
                          <th>№</th>
                          <th>ФИО</th>
                          <th>ОП</th>
                          <th>ФИО заказчика</th>
                          <th>Телефон</th>
                          <th>Дата</th>
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
                          <td><?php echo $abit['name'] ?></td>
                          <td><?php echo $abit['program'] ?></td>
                          <td><?php echo $abit['client'] ?></td>
                          <td><?php echo $abit['phone'] ?></td>
                          <td><?php echo $abit['date'] ?></td>
                        </tr>      
                        
                        <?php
                            }
                        ?>
                      
                      </table>
                </section>
        </div>
    </main>
</body>
</html>
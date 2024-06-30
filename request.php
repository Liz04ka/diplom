<?php 
    require("db.php");

    //получаем заявки только для выбранного факультета
    $id = $_GET['id'];

    $search = $_GET['search'] ?? null;

    //получаем информацию о выбранном факультете
    $course = $db->query("SELECT * FROM `courses` WHERE id=$id")->fetchAll(PDO::FETCH_ASSOC);

    // print_r($_GET);
    if (is_null($search)) {
        //получаем все заявки на данный факультет
        $requests = $db->query("SELECT * FROM `requests` WHERE id_course=$id AND status='send'")->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $requests = $db->query("SELECT * FROM `requests` WHERE id_course=$id AND status='send' AND id_abit=$search")->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Заявки на договор</title>
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

            <!-- на главную, название, поиск -->
            <section class="request-header pages-header">

                <!-- ссылка назад -->
                <a href="managerMain.php" class="backto">
                    На главную
                </a>
                
                <!-- название страницы -->
                <h2 class="request-header_title">
                    Заявки на договор на факультет <?php echo $course[0]['name'] ?>
                </h2>
            </section>

            <!-- поле для поиска -->
            <search role="search" class="search">
                <form method="GET" action="">
                    <input type="hidden" name="id" value="<?php echo $id?>">
                    <input class="search-input" type="search" name="search" placeholder="id"/>
                    <button class="search-btn" type="submit">Искать</button>
                </form>
            </search>

            <section class="request-table">
                <table>
                    <tr>
                      <th>ID</th>
                      <th>ФИО</th>
                      <th>ОП</th>
                      <th>Телефон</th>
                      <th>Почта</th>
                    </tr>
                    

                                         
                    <?php
                        foreach ($requests as $request) {
                    ?>
                        
                    <tr>
                      <td><a class="main-item_list-a" href="requestItem.php?id=<?php echo $request['id']?>"><?php echo $request['id_abit']?></a></td>
                      <td><?php echo $request['name']?></td>
                      <td><?php echo $request['program']?></td>
                      <td><?php echo $request['phone']?></td>
                      <td><?php echo $request['email']?></td>
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
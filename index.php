<?php 

    require("db.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Распределяющая страница</title>
</head>
<body>
    <div class="container menu">
        Статичные страницы:
        <a href="managerMain.php">1. Главная страница для менеджера</a>
        <a href="table.php">2. Таблицы с инфой о договорах</a>
        <a href="pay.php">3. страница с оплатами</a>
        <a href="contract.php">4. старница с самими файлами договоров</a>
        <a href="request.php">5. страница с запросами на договор</a>
        <a href="requestItem.php">6. страница с запросом на конкретный договор</a>
    </div>
</body>
</html>
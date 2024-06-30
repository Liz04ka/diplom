<?php

    require("db.php");

    print_r($_POST);
    $course = $_POST['course']; //id факультета
    $name = $_POST['name']; //фио абитуриента
    $program = $_POST['program']; //образовательная программа 
    $direct = $_POST['direct']; //направление подготовки 
    $client = $_POST['clientname']; //фио заказчика
    $passport = $_POST['passport']; //фио заказчика
    $issued = $_POST['issued']; //кем выдан
    $phone = $_POST['phone']; //телефон
    $email = $_POST['email']; //почта
    $date = new DateTime(); 
    $date = $date -> format('Y-m-d');//текущая дата
    $idabit = $_COOKIE['id'];
    // print_r($idabit);


    //валидируем данные, а именно проверяем на все их наличие
    $db->query("INSERT INTO requests (id_abit, id_course, name, program, client, passport, issued, phone, email, date, status, direct) VALUE ('$idabit', '$course', '$name', '$program', '$client', '$passport', '$issued', '$phone', '$email', '$date', 'send', '$direct')");
    
    header('Location: /diplom/abitstatus.php');

?>

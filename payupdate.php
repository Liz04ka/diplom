<?php 

print_r($_POST);

//id заявки
$idreq = $_POST['idrequests'];

//мне надо объединить таблицы заявки, контракты и оплаты, чтобы поменять статус этой заявки в оплатах на "отправлено"
$request = $db->query("SELECT * FROM payments JOIN contracts ON payments.idcontr = contracts.number JOIN requests ON requests.id = contracts.id_requests")->fetchAll(PDO::FETCH_ASSOC);

?>

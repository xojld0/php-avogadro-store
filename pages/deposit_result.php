<?php
	require_once(__DIR__."/../includes/db_connect.php"); // deposit_result.php <-- db_connect.php <-- config.php

	if(!isset($_SESSION['username']))
		header("Location: /pages/login.php");

	$username = htmlspecialchars($_SESSION['username']);


## ----- INTERKASSA ----- ##
	$dataSet = $_POST;

	unset($dataSet['ik_sign']); // удаляем из данных строку подписи
	ksort($dataSet, SORT_STRING); // сортируем по ключам в алфавитном порядке элементы массива
	array_push($dataSet, '3RipyPAKTqhjgdZU'); // добавляем в конец массива "секретный ключ"
	$signString = implode(':', $dataSet); // конкатенируем значения через символ ":"
	$sign = base64_encode(md5($signString, true)); // берем MD5 хэш в бинарном виде по сформированной строке и кодируем в BASE64

	if($_POST['ik_sign'] === $sign) {
		if($_POST['ik_co_id'] === '5d3812831ae1bde03d8b4567') {
			if($_POST['ik_inv_st'] === "success") {
				$add_balance_query = "UPDATE users SET balance=balance+:amount WHERE username = :username";
				$add_balance = $pdo->prepare($add_balance_query);
				$add_balance->execute(["amount" => $_POST['ik_am'], "username" => $username]);
			}
		}
	}
?>
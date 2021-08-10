<?php
	require_once(__DIR__."/config.php"); // db_connect.php <-- config.php

	try {
		$pdo = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	} catch(PDOException $e) {
		exit($e->getMessage());
	}
?>
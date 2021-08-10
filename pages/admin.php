<?php
	require_once(__DIR__."/../includes/db_connect.php"); // admin.php <-- db_connect.php <-- config.php

	if(!isset($_SESSION['username']))
		header("Location: /");

	$username = htmlspecialchars($_SESSION['username']);

	$valid = $pdo->prepare("SELECT * FROM users WHERE username = ?");
	$valid->execute([$username]);
	$valid = $valid->fetch(PDO::FETCH_ASSOC);

	if($valid['is_admin'] !== "1")
		header("Location: /");
?>
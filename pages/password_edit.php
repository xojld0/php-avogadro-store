<?php
	require_once(__DIR__."/../includes/db_connect.php"); // password_edit.php <-- db_connect.php <-- config.php

	if(!isset($_SESSION['username']))
		header("Location: /pages/login.php");

	$error = "";
	$psw_edit_msg = "";

	if(isset($_REQUEST['submit'])) {
		if(!empty($_REQUEST['password_old'])) {
			if(!empty($_REQUEST['password_1'])) {
				if(!empty($_REQUEST['password_2'])) {
					if($_REQUEST['kapcha'] === @$_SESSION['rand_code']) {
						if(trim(htmlspecialchars($_REQUEST['password_1'])) === trim(htmlspecialchars($_REQUEST['password_2']))) {
							$password_old = md5(trim(htmlspecialchars($_REQUEST['password_old'])));
							$password_new = md5(trim(htmlspecialchars($_REQUEST['password_1'])));

							$password_query = "SELECT id FROM users WHERE password = :password AND username = :username";
							$password_result = $pdo->prepare($password_query);
							$password_result->execute(["password" => $password_old, "username" => htmlspecialchars($_SESSION['username'])]);
							$password_result = $password_result->fetch(PDO::FETCH_ASSOC);

							if($password_result) {
								$new_password_query = "UPDATE users SET password = :new_password WHERE id = :id";
								$new_password_result = $pdo->prepare($new_password_query);
								if($new_password_result->execute(["new_password" => $password_new, "id" => $password_result['id']])) {
									$psw_edit_msg = $psw_edit_success;
								} else {
									$error = $psw_edit_error6;
								}
							} else {
								$error = $psw_edit_error5;
							}
						} else {
							$error = $psw_edit_error4;
						}
					} else {
						$error = $captcha_error;
					}
				} else {
					$error = $psw_edit_error3;
				}
			} else {
				$error = $psw_edit_error2;
			}
		} else {
			$error = $psw_edit_error1;
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?>
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?>

		<div class="password_edit">
			<center><?=$error?></center>
			<center><?=$psw_edit_msg?></center>
			<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST">
				<table>
					<tr><td><?=$psw_edit_old_password?></td><td><input type="password" name="password_old"></td></tr>
					<tr><td><?=$psw_edit_password1?></td><td><input type="password" name="password_1"></td></tr>
					<tr><td><?=$psw_edit_password2?></td><td><input type="password" name="password_2"></td></tr>
					<tr><td><?=$captcha?></td><td><input type="text" name="kapcha"></td></tr>
				</table>
				<center><img src="/includes/captcha.php" class="captcha" style="margin-left: 6%"></center>
				<center><input type="submit" name="submit" value="<?=$psw_edit_submit?>"></center>
			</form>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?>
</html>

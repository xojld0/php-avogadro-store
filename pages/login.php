<?php
	require_once(__DIR__."/../includes/db_connect.php"); // login.php <-- db_connect.php <-- config.php

	if(isset($_SESSION['username']))
		header("Location: /");

	$error = "";

	if(isset($_REQUEST['submit'])) {
		if(!empty($_REQUEST['email'])) {
			if(!empty($_REQUEST['password'])) {
				if(preg_match($preg_email_pattern, $_REQUEST['email']) !== 0) {
					try {
						$email = trim(htmlspecialchars($_REQUEST['email']));
						$email_query = "SELECT * FROM users WHERE email = ?";
						$email_exist = $pdo->prepare($email_query);
						$email_exist->execute([$email]);
						$email_exist = $email_exist->fetch(PDO::FETCH_ASSOC);
					} catch(PDOException $e) {
						exit($e->getMessage);
					}

					if($email_exist['username']) {
						$password = md5(trim(htmlspecialchars($_REQUEST['password'])));
						if($email_exist['password'] === $password) {
							$_SESSION['username'] = $email_exist['username'];
							header("Location: /pages/profile.php");
						} else {
							$error = $login_error5;
						}
					} else {
						$error = $login_error4;
					}
				} else {
					$error = $login_error3;
				}
			} else {
				$error = $login_error2;
			}
		} else {
			$error = $login_error1;
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?>
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?>

		<div class="login">
			<center><?=$error?></center>
			<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST" class="form">
				<table>
					<tr><td><?=$login_email?></td><td><input type="text" name="email"></td></tr>
					<tr><td><?=$login_password?></td><td><input type="password" name="password"></td></tr>
				</table>
				<center><input type="submit" name="submit" value="<?=$login_submit?>"></center>
				<center><a href="/pages/password_recovery.php"><?=$login_recovery?></a></center>
			</form>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?>
</html>

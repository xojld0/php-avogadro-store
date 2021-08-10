<?php
	require_once(__DIR__."/../includes/db_connect.php"); // password_recovery.php <-- db_connect.php <-- config.php

	if(isset($_SESSION['username']))
		header("Location: /pages/password_edit.php");

	$error = "";
	$recovery_msg = "";

	if(isset($_GET['hash'])) {
		$hash = htmlspecialchars($_GET['hash']);
		$hash_query = "SELECT * FROM password_recovery WHERE hash = ?";
		$hash_exist = $pdo->prepare($hash_query);
		$hash_exist->execute([$hash]);
		$hash_exist = $hash_exist->fetch(PDO::FETCH_ASSOC);

		if(isset($hash_exist['hash'])) {
			$recovery_bool = true;

			if(isset($_REQUEST['submit_recovery'])) {
				if(!empty($_REQUEST['password_1'])) {
					if(!empty($_REQUEST['password_2'])) {
						if(trim(htmlspecialchars($_REQUEST['password_1'])) === trim(htmlspecialchars($_REQUEST['password_2']))) {
							$password = md5(trim(htmlspecialchars($_REQUEST['password_1'])));
							$password_query = "UPDATE users SET password = :password WHERE id = :account_id";
							$password_result = $pdo->prepare($password_query);
							if($password_result->execute(["password" => $password, "account_id" => $hash_exist['account_id']])) {
								$delete_query = "DELETE FROM password_recovery WHERE hash = ?";
								$delete = $pdo->prepare($delete_query);
								if($delete->execute([$hash])) {
									$user_query = "SELECT username FROM users WHERE id = ?";
									$user_result = $pdo->prepare($user_query);
									if($user_result->execute([$hash_exist['account_id']])) {
										$_SESSION['username'] = $user_result->fetch(PDO::FETCH_ASSOC)['username'];
										header("Location: /pages/profile.php");
									}
								}
							}
						} else {
							$error = $recovery_error6;
						}
					} else {
						$error = $recovery_error5;
					}
				} else {
					$error = $recovery_error4;
				}
			}
		}
	}

	if(isset($_REQUEST['submit'])) {
		if(!empty($_REQUEST['email'])) {
			if($_REQUEST['kapcha'] === @$_SESSION['rand_code']) {
				if(preg_match($preg_email_pattern, $_REQUEST['email']) !== 0) {
					$email = trim(htmlspecialchars($_REQUEST['email']));
					$email_query = "SELECT * FROM users WHERE email = ?";
					$email_exist = $pdo->prepare($email_query);
					$email_exist->execute([$email]);
					$email_exist = $email_exist->fetch(PDO::FETCH_ASSOC);

					if($email_exist) {
						$hash = md5($email.$email_exist['password'].time());
						$recovery_query = "INSERT INTO password_recovery VALUES (NULL, :account_id, :hash)";
						$recovery = $pdo->prepare($recovery_query);
						if($recovery->execute(["account_id" => $email_exist['id'], "hash" => $hash])) {
							mail($email, $recovery_subject, $recovery_content.' <a href="'.$url.'/pages/password_recovery.php?hash='.$hash.'">'.$url.'/pages/password_recovery.php?hash='.$hash.'</a>', "Content-Type: text/html; charset=UTF-8\r\n");
							$recovery_msg = $recovery_message;
						}
					} else {
						$error = $recovery_error3;
					}
				} else {
					$error = $recovery_error2;
				}
			} else {
				$error = $captcha_error;
			}
		} else {
			$error = $recovery_error1;
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?>
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?>

		<div class="password_recovery">
			<center><?=$error?></center>
			<center><?=$recovery_msg?></center>
			<?php if(isset($recovery_bool) && $recovery_bool === true): ?>
				<form action="<?=$_SERVER['SCRIPT_NAME']?>?hash=<?=$_GET['hash']?>" method="POST">
					<table>
						<tr><td><?=$recovery_password1?></td><td><input type="password" name="password_1"></td></tr>
						<tr><td><?=$recovery_password2?></td><td><input type="password" name="password_2"></td></tr>
					</table>
					<center><input type="submit" name="submit_recovery" value="<?=$recovery_submit?>"></center>
				</form>
			<?php else: ?>
				<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST">
					<table>
						<tr><td><?=$recovery_email?></td><td><input type="text" name="email"></td></tr>
						<tr><td><?=$captcha?></td><td><input type="text" name="kapcha"></td></tr>
					</table>
					<center><img src="/includes/captcha.php" class="captcha" style="margin-left: 6%"></center>
					<center><input type="submit" name="submit" value="<?=$recovery_submit?>"></center>
				</form>
			<?php endif; ?>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?>
</html>

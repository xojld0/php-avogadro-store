<?php
	require_once(__DIR__."/../includes/db_connect.php"); // email_edit.php <-- db_connect.php <-- config.php

	if(!isset($_SESSION['username']))
		header("Location: /pages/login.php");

	$error = "";
	$email_edit_msg = "";

	if(isset($_GET['hash'])) {
		$hash = htmlspecialchars($_GET['hash']);
		$hash_query = "SELECT * FROM email_edit WHERE hash = ?";
		$hash_exist = $pdo->prepare($hash_query);
		if($hash_exist->execute([$hash])) {
			$hash_exist = $hash_exist->fetch(PDO::FETCH_ASSOC);
			if($hash_exist) {
				$username = htmlspecialchars($_SESSION['username']);
				$email = trim(htmlspecialchars($hash_exist['email']));
				$new_email_query = "UPDATE users SET email = :email WHERE id = :id";
				$new_email_result = $pdo->prepare($new_email_query);
				if($new_email_result->execute(["email" => $email, "id" => $hash_exist['account_id']])) {
					$delete_query = "DELETE FROM email_edit WHERE id = ?";
					$delete = $pdo->prepare($delete_query);
					if($delete->execute([$hash_exist['id']])) {
						$email_edit_msg = $email_edit_success;
					} else {
						$error = $email_edit_error3;
					}
				} else {
					$error = $email_edit_error3;
				}
			} else {

			}
		} else {
			$error = $email_edit_error4;
		}
	}

	if(isset($_REQUEST['submit'])) {
		if(!empty($_REQUEST['email'])) {
			if($_REQUEST['kapcha'] === @$_SESSION['rand_code']) {
				if(preg_match($preg_email_pattern, $_REQUEST['email']) !== 0) {
					$email = trim(htmlspecialchars($_REQUEST['email']));

					$check_email_query = "SELECT * FROM users WHERE email = ?";
					$check_email = $pdo->prepare($check_email_query);
					$check_email->execute([$email]);
					$check_email = $check_email->fetch(PDO::FETCH_ASSOC);

					if(!$check_email) {
						$email_query = "SELECT id, email FROM users WHERE username = ?";
						$user = $pdo->prepare($email_query);
						$user->execute([htmlspecialchars($_SESSION['username'])]);
						$user = $user->fetch(PDO::FETCH_ASSOC);

						if($user) {
							$hash = md5($email.htmlspecialchars($_SESSION['username']).time());
							$hash_query = "INSERT INTO email_edit VALUES (NULL, :account_id, :hash, :email)";
							$hash_result = $pdo->prepare($hash_query);

							if($hash_result->execute(["account_id" => $user['id'], "hash" => $hash, "email" => $email])) {
								mail($user['email'], $email_edit_subject, $email_edit_content.' <a href="'.$url.'/pages/email_edit.php?hash='.$hash.'">'.$url.'/pages/email_edit.php?hash='.$hash.'</a>', "Content-Type: text/html; charset=UTF-8\r\n");
								$email_edit_msg = $email_edit_message;
							} else {
								$error = $email_edit_error3;
							}
						}
					} else {
						$error = $email_edit_error5;
					}
				} else {
					$error = $email_edit_error2;
				}
			} else {
				$error = $captcha_error;
			}
		} else {
			$error = $email_edit_error1;
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?>
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?>

		<div class="email_edit">
			<center><?=$error?></center>
			<center><?=$email_edit_msg?></center>
			<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST">
				<table>
					<tr><td><?=$email_edit_new?></td><td><input type="text" name="email"></td></tr>
					<tr><td><?=$captcha?></td><td><input type="text" name="kapcha"></td></tr>
				</table>
				<center><img src="/includes/captcha.php" class="captcha" style="margin-left: 6%"></center>
				<center><input type="submit" name="submit" value="<?=$email_edit_submit?>"></center>
			</form>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?>
</html>

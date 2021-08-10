<?php
	require_once(__DIR__."/../includes/db_connect.php"); // registration.php <-- db_connect.php <-- config.php

	$error = "";
	$email_activation = "";

	if(isset($_GET['activation'])) {
		$activation_code = htmlspecialchars($_GET['activation']);
		$activation_query = "SELECT id, activation FROM users WHERE activation = ?";
		$activation_result = $pdo->prepare($activation_query);
		$activation_result->execute([$activation_code]);
		$activation_fetch = $activation_result->fetch(PDO::FETCH_ASSOC);

		if($activation_fetch) {
			$query = "UPDATE users SET activation = '1' WHERE id = ?";
			$result = $pdo->prepare($query);
			if($result->execute([$activation_fetch['id']])) {
				$email_activation = $registration_success;
			} else {
				$email_activation = $registration_sysfail;
			}
		}
	}

	if(isset($_REQUEST['submit']) && empty($email_activation)) {
		if(!empty($_REQUEST['email'])) {
			if(!empty($_REQUEST['username'])) {
				if(!empty($_REQUEST['password_1'])) {
					if(!empty($_REQUEST['password_2'])) {
						if($_REQUEST['kapcha'] === @$_SESSION['rand_code']) {
							if(preg_match($preg_email_pattern, $_REQUEST['email']) !== 0) {
								$email = trim(htmlspecialchars($_REQUEST['email']));
								$email_query = "SELECT email FROM users WHERE email = ?";
								$email_exist = $pdo->prepare($email_query);
								$email_exist->execute([$email]);

								if(!$email_exist->fetch()) {
									if(preg_match($preg_username_pattern, $_REQUEST['username']) !== 0) {
										$username = trim(htmlspecialchars($_REQUEST['username']));
										$user_query = "SELECT username FROM users WHERE username = ?";
										$user_exist = $pdo->prepare($user_query);
										$user_exist->execute([$username]);

										if(!$user_exist->fetch()) {
											if($_REQUEST['password_1'] === $_REQUEST['password_2']) {
												$password = md5(trim(htmlspecialchars($_REQUEST['password_1'])));
												$activation = md5($email.time());

												$query = "INSERT INTO users VALUES (NULL, :email, :username, :password, 0, :activation, 0)";
												$register = $pdo->prepare($query);
												if($register->execute(["email" => $email, "username" => $username, "password" => $password, "activation" => $activation])) {
													$_SESSION['username'] = $username;
													mail($email, $registration_subject, $registration_content.' <a href="'.$url.'/pages/registration.php?activation='.$activation.'">'.$url.'/pages/registration.php?activation='.$activation.'</a>', "Content-Type: text/html; charset=UTF-8\r\n");
													$email_activation = $registartion_sendmail;
													unset($_REQUEST['submit']);
												} else {
													$error = $registration_error10;
												}
											} else {
												$error = $registration_error9;
											}
										} else {
											$error = $registration_error8;
										}
									} else {
										$error = $registration_error7;
									}
								} else {
									$error = $registration_error6;
								}
							} else {
								$error = $registration_error5;
							}
						} else {
							$error = $captcha_error;
						}
					} else {
						$error = $registration_error4;
					}
				} else {
					$error = $registration_error3;
				}
			} else {
				$error = $registration_error2;
			}
		} else {
			$error = $registration_error1;
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?> <!-- HEAD -->
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?> <!-- TOOLBAR -->

		<div class="registration">
			<center><?=$error?></center>
			<center><?=$email_activation?></center>
			<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST" class="form">
				<table>
					<tr><td><?=$registration_email?></td><td><input type="text" name="email"></td></tr>
					<tr><td><?=$registration_username?></td><td><input type="text" name="username"></td></tr>
					<tr><td><?=$registration_password1?></td><td><input type="password" name="password_1"></td></tr>
					<tr><td><?=$registration_password2?></td><td><input type="password" name="password_2"></td></tr>
					<tr><td><?=$captcha?></td><td><input type="text" name="kapcha"></td></tr>
				</table>
				<img src="/includes/captcha.php" class="captcha">
				<center><input type="submit" name="submit" value="<?=$registration_submit?>"></center>
			</form>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?> <!-- FOOTER -->
</html>

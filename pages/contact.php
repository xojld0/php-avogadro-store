<?php
	require_once(__DIR__."/../includes/db_connect.php"); // contact.php <-- db_connect.php <-- config.php

	$error = "";
	$contact_msg = "";

	function contacts() : string {
		global $pdo;

		$contacts = $pdo->query("SELECT * FROM contacts");
		$result = "";

		foreach($contacts->fetchAll(PDO::FETCH_ASSOC) as $contact) {
			$result .= $contact['text']."&nbsp;&nbsp;&nbsp;&nbsp;";
		}

		return preg_replace('/^ (.*?) .{24} $/xis', "$1", $result);
	}

	if(isset($_SESSION['username'])) {
		$username = htmlspecialchars($_SESSION['username']);
		if(isset($_REQUEST['submit'])) {
			if(!empty($_REQUEST['message'])) {
				if($_REQUEST['kapcha'] === @$_SESSION['rand_code']) {
					$message = trim(htmlspecialchars($_REQUEST['message']));

					$email_query = "SELECT email FROM users WHERE username = ?";
					$email_exist = $pdo->prepare($email_query);

					if($email_exist->execute([$username])) {
						$message_query = "INSERT INTO messages VALUES (NULL, :username, :email, :message, :_date)";
						$message_send = $pdo->prepare($message_query);
						if($message_send->execute(["username" => $username, "email" => $email_exist->fetch()['email'], "message" => $message, "_date" => date("y-m-d")])) {
							$_SESSION['message'] = $contact_success;
							header("Location: /pages/contact.php");
						} else {
							$error = $contact_error2;
						}
					} else {
						$error = $contact_error2;
					}
				} else {
					$error = $captcha_error;
				}
			} else {
				$error = $contact_error1;
			}
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?>
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?>

		<div class="contact">
			<center><?=$error?></center>
			<center><?php if(isset($_SESSION['message']) && !isset($_REQUEST['submit'])) { echo $_SESSION['message']; unset($_SESSION['message']); } ?></center>
			<?php if(isset($_SESSION['username'])): ?>
				<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST">
					<table>
						<tr><td><?=$contact_message?></td></tr>
						<tr><td><textarea name="message" cols="61" rows="9"></textarea></td></tr>
					</table>
					<table><tr><td><?=$captcha?></td><td><input type="text" name="kapcha"></td></tr></table>
					<center><img src="/includes/captcha.php" class="captcha" style="margin-left: 8%"></center>
					<center><input type="submit" name="submit" value="<?=$contact_submit?>"></center>
				</form>
			<?php else: ?>
				<p><a href="/pages/login.php">Авторизуйтесь</a> чтобы отправть сообщение администратору.</p>
			<?php endif;?>
			<center><p><?=contacts()?></p></center>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?>
</html>

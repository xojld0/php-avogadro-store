<?php
	require_once(__DIR__."/../includes/db_connect.php"); // promo.php <-- db_connect.php <-- config.php

	if(!isset($_SESSION['username']))
		header("Location: /pages/login.php");

	$username = htmlspecialchars($_SESSION['username']);

	$error = "";
	$promo_msg = "";

	if(isset($_REQUEST['submit'])) {
		if(!empty($_REQUEST['promocode'])) {
			if($_REQUEST['kapcha'] === @$_SESSION['rand_code']) {
				$promocode = trim(htmlspecialchars($_REQUEST['promocode']));
				$promo_query = "SELECT * FROM promocodes WHERE promocode = ?";
				$promo_exist = $pdo->prepare($promo_query);

				if($promo_exist->execute([$promocode])) {
					$promo_exist = $promo_exist->fetch(PDO::FETCH_ASSOC);
					if($promo_exist) {
						$delete_query = "DELETE FROM promocodes WHERE id = ?";
						$delete = $pdo->prepare($delete_query);
						if($delete->execute([$promo_exist['id']])) {
							$user_query = "UPDATE users SET balance=balance+:amount WHERE username = :username";
							$user_result = $pdo->prepare($user_query);

							if($user_result->execute(["amount" => $promo_exist['amount'], "username" => $username])) {
								$promo_msg = $promo_success."<p style='color: green'>".$promo_exist['amount'].$currency."</p>";
							} else {
								$error = $promo_error2;
							}
						} else {
							$error = $promo_error2;
						}
					} else {
						$error = $promo_error3;
					}
				} else {
					$error = $promo_error2;
				}
			} else {
				$error = $captcha_error;
			}
		} else {
			$error = $promo_error1;
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?>
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?>

		<div class="promo">
			<center><?=$error?></center>
			<center><?=$promo_msg?></center>
			<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST">
				<table>
					<tr><td><?=$promo_enter?></td><td><input type="text" name="promocode"></td></tr>
					<tr><td><?=$captcha?></td><td><input type="text" name="kapcha"></td></tr>
				</table>
				<center><img src="/includes/captcha.php" class="captcha" style="margin-left: 6%"></center>
				<center><input type="submit" name="submit" value="<?=$promo_submit?>"></center>
			</form>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?>
</html>

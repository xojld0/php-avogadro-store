<?php
	require_once(__DIR__."/../includes/db_connect.php"); // profile.php <-- db_connect.php <-- config.php

	if(!isset($_SESSION['username']))
		header("Location: /pages/login.php");

	$username = htmlspecialchars($_SESSION['username']);

	function return_email_activation($activation) : string {
		if($activation === "1")
			return $GLOBALS['profile_email_active'];
		else
			return $GLOBALS['profile_email_unactive'];
	}

	function echo_account_info() {
		global $username;
		global $pdo;

		$user_query = "SELECT * FROM users WHERE username = ?";
		$user_exist = $pdo->prepare($user_query);
		$user_exist->execute([$username]);
		$user_exist = $user_exist->fetch(PDO::FETCH_ASSOC);

		if(isset($user_exist['username'])) {
			echo "
				<table>
					<tr><td>{$GLOBALS['profile_email']}</td><td>{$user_exist['email']}</td><td style='width: 147px'>".return_email_activation($user_exist['activation'])."</td>"./*<td><a href='/pages/email_edit.php'>{$GLOBALS['profile_email_edit']}</a></td>*/"</tr>
					<tr><td>{$GLOBALS['profile_username']}</td><td>{$user_exist['username']}</td></tr>
					<tr><td>{$GLOBALS['profile_balance']}</td><td>{$user_exist['balance']}</td><td><a href='/pages/deposit.php'>{$GLOBALS['profile_deposit']}</a></td></tr>
				</table>
				<table>
					<tr><td><a href='/pages/email_edit.php'>{$GLOBALS['profile_email_edit']}</a></td><td><a href='/pages/password_edit.php'>{$GLOBALS['profile_password_edit']}</a></td><td><a href='/pages/promo.php'>{$GLOBALS['profile_promo_enter']}</a></td></tr>
				</table>
			";
		} else {
			exit($GLOBALS['profile_error1']);
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?>
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?>

		<div class="profile">
			<?php echo_account_info(); ?>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?>
</html>

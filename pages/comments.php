<?php
	require_once(__DIR__."/../includes/db_connect.php"); // comments.php <-- db_connect.php <-- config.php

	$error = "";

	function echo_comments() {
		global $pdo;

		$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 1;
		$prev = $page - 1;
		$next = $page + 1;
		$limit = $page * 10;
		$start = $limit - 10;

		$pages_count = $pdo->query("SELECT COUNT(*) FROM comments");

		$comments = $pdo->prepare("SELECT * FROM comments ORDER BY `date` DESC LIMIT :start, :_limit");
		$comments->bindParam(':start', $start, PDO::PARAM_INT);
		$comments->bindParam(':_limit', $limit, PDO::PARAM_INT);
		if($comments->execute()) {
			foreach($comments->fetchAll(PDO::FETCH_ASSOC) as $item) {
				echo "
					<p class='comment'>
						<i>{$item['date']}</i>&nbsp;&#8209;&nbsp;<strong>{$item['username']}</strong><br />
						{$item['comment']}
					</p><br />
				";
			}
		} else {
			$error = $GLOBALS['comments_error2'];
		}

		if($limit > 10)
			echo "<center><a href='/pages/comments.php?page={$prev}' class='comment_prev'>{$GLOBALS['comments_prev']}</a></center>";
		if($limit < $pages_count->fetch()[0])
			echo "<center><a href='/pages/comments.php?page={$next}' class='comment_next'>{$GLOBALS['comments_next']}</a></center>";
	}

	if(isset($_SESSION['username'])) {
		if(isset($_REQUEST['submit'])) {
			if(!empty($_REQUEST['comment'])) {
				if($_REQUEST['kapcha'] === @$_SESSION['rand_code']) {
					$comment = trim(nl2br(htmlspecialchars($_REQUEST['comment'])));
					$comment_query = "INSERT INTO comments VALUES (NULL, :username, :comment, :_date)";
					$comment_result = $pdo->prepare($comment_query);
					if($comment_result->execute(["username" => htmlspecialchars($_SESSION['username']), "comment" => $comment, "_date" => date("y-m-d h:i:s")])) {
						unset($_REQUEST['submit']);
						header("Location: /pages/comments.php");
					} else {
						$error = $comments_error2;
					}
				} else {
					$error = $captcha_error;
				}
			} else {
				$error = $comments_error1;
			}
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?> <!-- HEAD -->
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?> <!-- TOOLBAR -->

		<div class="comments">
			<?php if(isset($_SESSION['username'])): ?>
				<center><?=$error?></center>
				<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST">
					<table>
						<tr><td><?=$comments_text?></td></tr>
						<tr><td><textarea name="comment" cols="61" rows="9"></textarea></td></tr>
					</table>
					<table><tr><td><?=$captcha?></td><td><input type="text" name="kapcha"></td></tr></table>
					<center><img src="/includes/captcha.php" class="captcha" style="margin-left: 6%"></center>
					<center><input type="submit" name="submit" value="<?=$comments_submit?>"></center>
				</form>
			<?php endif; ?>
		</div>
		<?php echo_comments(); ?>
	<?php require_once(__DIR__."/../includes/footer.php"); ?> <!-- FOOTER -->
</html>

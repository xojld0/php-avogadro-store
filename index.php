<?php
	require_once(__DIR__."/includes/db_connect.php"); // index.php <-- db_connect.php <-- config.php

	function echo_news() {
		global $pdo;

		$news = $pdo->query("SELECT `title`, `content`, DATE_FORMAT(date,'%d.%m.%Y') AS `date`, `username` FROM news ORDER BY `date`");

		foreach($news->fetchAll(PDO::FETCH_ASSOC) as $item) {
			echo "
				<p>
					<h2>{$item['title']}</h2>
					{$item['content']}<br /><br />
					<i>{$item['date']}</i> - <strong>{$item['username']}</strong>
				</p><br />
			";
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/includes/head.php"); ?> <!-- HEAD -->
		<?php require_once(__DIR__."/includes/toolbar.php"); ?> <!-- TOOLBAR -->

		<!-- NEWS -->
		<div class="news">
			<?php echo_news(); ?>
		</div>
	<?php require_once(__DIR__."/includes/footer.php"); ?> <!-- FOOTER -->
</html>

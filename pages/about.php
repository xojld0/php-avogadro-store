<?php
	require_once(__DIR__."/../includes/db_connect.php"); // about.php <-- db_connect.php <-- config.php

	function echo_text() {
		global $pdo;

		$about = $pdo->query("SELECT * FROM about ORDER BY id");

		foreach($about->fetchAll(PDO::FETCH_ASSOC) as $item) {
			echo "
				<p>
					<h2>{$item['title']}</h2>
					{$item['content']}<br /><br />
				</p><br />
			";
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?> <!-- HEAD -->
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?> <!-- TOOLBAR -->

		<!-- NEWS -->
		<div class="about">
			<?php echo_text(); ?>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?> <!-- FOOTER -->
</html>

<?php
	require_once(__DIR__."/../includes/db_connect.php"); // deposit_success.php <-- db_connect.php <-- config.php
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?> <!-- HEAD -->
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?> <!-- TOOLBAR -->

		<div class="deposit">
			<center><?=$deposit_error?></center>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?> <!-- FOOTER -->
</html>

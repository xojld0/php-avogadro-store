<?php
	require_once(__DIR__."/../includes/db_connect.php"); // deposti.php <-- db_connect.php <-- config.php

	if(!isset($_SESSION['username']))
		header("Location: /pages/login.php");
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?> <!-- HEAD -->
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?> <!-- TOOLBAR -->

		<div class="deposit">
			<form id="payment" name="payment" method="POST" action="https://sci.interkassa.com/" enctype="utf-8">
				<table>
					<input type="hidden" name="ik_co_id" value="5d3812831ae1bde03d8b4567">
					<input type="hidden" name="ik_pm_no" value="<?=time()?>">
					<tr><td><?=$deposit_value?></td><td><input type="text" name="ik_am" value="100"></td></tr>
					<input type="hidden" name="ik_cur" value="RUB">
					<input type="hidden" name="ik_desc" value="Event Description">
				</table>
			    <center><input type="submit" value="<?=$deposit_submit?>"></center>
			</form>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?> <!-- FOOTER -->
</html>

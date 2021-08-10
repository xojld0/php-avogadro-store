<?php
	require_once(__DIR__."/../includes/db_connect.php"); // product.php <-- db_connect.php <-- config.php

	function echo_product() {
		global $pdo;

		$id = htmlspecialchars($GLOBALS['_GET']['id']);

		$product_query = "SELECT * FROM products WHERE id = ?";
		$product = $pdo->prepare($product_query);
		$product->execute([$id]);
		$product = $product->fetch(PDO::FETCH_ASSOC);

		if($product) {
			echo "
				<table>
					<tr><td><img class='product_page_img' src='{$product['img']}' width='400px' height='400px'></td>
					<td valign='top'><p class='product_page_name'>{$product['product_name']}</p>
					<p class='product_page_description'>{$product['description']}</p></td></tr>
					<tr><td><p class='product_page_price'>{$product['price']}{$GLOBALS['currency']}</p></td>"; if($product['count'] > 0) echo "<td><a href='/pages/buy.php?id={$product['id']}'>{$GLOBALS['product_buy']}</a></td>"; echo "</tr>
					<tr><td><p class='product_page_count'>{$GLOBALS['products_count']} {$product['count']}</p></td></tr>
				</table>
			";
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?>
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?>

		<div class="product_page">
			<?php echo_product(); ?>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?>
</html>

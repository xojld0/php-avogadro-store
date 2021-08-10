<?php
	require_once(__DIR__."/../includes/db_connect.php"); // products.php <-- db_connect.php <-- config.php

	function echo_products() {
		global $pdo;

		$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 1;
		$prev = $page - 1;
		$next = $page + 1;
		$limit = $page * 12;
		$start = $limit - 12;

		$pages_count = $pdo->query("SELECT COUNT(*) FROM products");

		$products = $pdo->prepare("SELECT * FROM products ORDER BY id LIMIT :start, :_limit");
		$products->bindParam(':start', $start, PDO::PARAM_INT);
		$products->bindParam(':_limit', $limit, PDO::PARAM_INT);
		$products->execute();

		$i = 0;
		foreach($products->fetchAll(PDO::FETCH_ASSOC) as $product) {
			++$i;
			echo "
				<div class='product'>
					<img src='{$product['img']}' width='200px' height='200px' name='img'>
					<p class='product_name'><a href='/pages/product.php?id={$product['id']}'>{$product['product_name']}</a></p>
					<p class='product_count'>{$GLOBALS['products_count']}   {$product['count']}</p>
					<p class='product_price'>{$product['price']}{$GLOBALS['currency']}</p>
				</div>
			";

			if($i % 4 === 0)
				echo "<div class='clear'></div>";
		}

		echo "<div class='clear'></div>";

		if($limit > 12)
			echo "<center><a href='/pages/products.php?page={$prev}' class='products_prev'>{$GLOBALS['comments_prev']}</a></center>";
		if($limit < $pages_count->fetch()[0])
			echo "<center><a href='/pages/products.php?page={$next}' class='products_next'>{$GLOBALS['comments_next']}</a></center>";
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?>
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?>

		<dir class="products">
			<?php echo_products(); ?>
		</dir>
		<div class="clear"></div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?>
</html>

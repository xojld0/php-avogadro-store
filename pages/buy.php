<?php
	require_once(__DIR__."/../includes/db_connect.php"); // buy.php <-- db_connect.php <-- config.php

	if(!isset($_SESSION['username']))
		header("Location: /pages/login.php");

	if(!isset($_GET['id']))
		header("Location: /");

	$username = htmlspecialchars($_SESSION['username']);
	$id = htmlspecialchars($_GET['id']);

	$error = "";

	if(isset($_REQUEST['submit'])) {
		if(!empty($_REQUEST['name'])) {
			if(!empty($_REQUEST['surname'])) {
				if(!empty($_REQUEST['address'])) {
					if(!empty($_REQUEST['city'])) {
						if(!empty($_REQUEST['region'])) {
							if(!empty($_REQUEST['index'])) {
								if(!empty($_REQUEST['country'])) {
									$name = trim(htmlspecialchars($_REQUEST['name']));
									$surname = trim(htmlspecialchars($_REQUEST['surname']));
									$address = trim(htmlspecialchars($_REQUEST['address']));
									$city = trim(htmlspecialchars($_REQUEST['city']));
									$region = trim(htmlspecialchars($_REQUEST['region']));
									$index = trim(htmlspecialchars($_REQUEST['index']));
									$country = trim(htmlspecialchars($_REQUEST['country']));

									$user_query = "SELECT * FROM users WHERE username = ?";
									$user = $pdo->prepare($user_query);
									$user->execute([$username]);
									$user = $user->fetch(PDO::FETCH_ASSOC);

									$product_query = "SELECT * FROM products WHERE id = ?";
									$product = $pdo->prepare($product_query);
									$product->execute([$id]);
									$product = $product->fetch(PDO::FETCH_ASSOC);

									if($product) {
										if($user['balance'] >= $product['price']) {
											$buy_1_query = "UPDATE users SET balance=balance-{$product['price']} WHERE id = {$user['id']}";
											$buy_2_query = "UPDATE products SET count=count-1 WHERE id = {$product['id']}";
											$buy_3_query = "INSERT INTO purchases VALUES (NULL, :username, :name, :surname, :company, :address, :city, :region, :index, :country, :_date)";

											if($pdo->query($buy_1_query)) {
												if($pdo->query($buy_2_query)) {
													$buy = $pdo->prepare($buy_3_query);
													if($buy->execute(["username" => $username, "name" => $name, "surname" =>$surname, "company" => trim(htmlspecialchars($_REQUEST['company'])), "address" => $address, "city" => $city, "region" => $region, "index" => $index, "country" => $country, "_date" => date("y-m-d h:i:s")])) {
														$_SESSION['buy_msg'] = $buy_success;
														header("Location: /pages/buy.php?id={$id}");
													} else {
														$error = $buy_error9;
													}
												}
											} else {
												$error = $buy_error9;
											}
										} else {
											$error = $buy_error8;
										}
									}
								} else {
									$error = $buy_error7;
								}
							} else {
								$error = $buy_error6;
							}
						} else {
							$error = $buy_error5;
						}
					} else {
						$error = $buy_error4;
					}
				} else {
					$error = $buy_error3;
				}
			} else {
				$error = $buy_error2;
			}
		} else {
			$error = $buy_error1;
		}
	}
?>
<!DOCTYPE html5>
<html lang="ru">
	<?php require_once(__DIR__."/../includes/head.php"); ?>
		<?php require_once(__DIR__."/../includes/toolbar.php"); ?>

		<div class="buy">
			<center><?=$error?></center>
			<?php if(!isset($_REQUEST['submit']) && isset($_SESSION['buy_msg'])) { echo "<center>".$_SESSION['buy_msg']."</center>"; unset($_SESSION['buy_msg']); }?>
			<form action="<?=$_SERVER['SCRIPT_NAME']?>?id=<?=$id?>" method="POST">
				<table>
					<tr><td><?=$buy_name?></td><td><input type="text" name="name" value="Иван"></td></tr>
					<tr><td><?=$buy_surname?></td><td><input type="text" name="surname" value="Иванов"></td></tr>
					<tr><td><?=$buy_company?></td><td><input type="text" name="company" value="Apple"></td></tr>
					<tr><td><?=$buy_address?></td><td><input type="text" name="address" value="у. Гамова д. 10 кв. 5"></td></tr>
					<tr><td><?=$buy_city?></td><td><input type="text" name="city" value="Москва"></td></tr>
					<tr><td><?=$buy_region?></td><td><input type="text" name="region" value="Московская обл."></td></tr>
					<tr><td><?=$buy_index?></td><td><input type="text" name="index" value="101000"></td></tr>
					<tr><td><?=$buy_country?></td><td><input type="text" name="country" value="Россия"></td></tr>
				</table>
				<center><input type="submit" name="submit" value="<?=$buy_submit?>"></center>
			</form>
		</div>
	<?php require_once(__DIR__."/../includes/footer.php"); ?>
</html>

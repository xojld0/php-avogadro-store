<h1 class="title"><a href="/"><?=$page_title?></a></h1>
<div class="toolbar">
	<ul>
		<li><a href="/"><?=$menu_index?></a></li>
		<li><a href="/pages/products.php"><?=$menu_products?></a></li>
		<?php if(isset($_SESSION['username'])): ?>
			<li><a href="/pages/profile.php"><?=$menu_profile?></a></li>
			<li><a href="/pages/logout.php"><?=$menu_logout?></a></li>
		<?php else: ?>
			<li><a href="/pages/registration.php"><?=$menu_registration?></a></li>
			<li><a href="/pages/login.php"><?=$menu_login?></a></li>
		<?php endif; ?>
		<li><a href="/pages/about.php"><?=$menu_about?></a></li>
		<li><a href="/pages/comments.php"><?=$menu_comment?></a></li>
		<li><a href="/pages/contact.php"><?=$menu_contact?></a></li>
	</ul>
</div>